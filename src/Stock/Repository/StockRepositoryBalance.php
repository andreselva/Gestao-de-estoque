<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

class StockRepositoryBalance implements StockRepositoryBalanceInterface
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function addBalance(Stock $stockMovement): void
    {
        $sql = "INSERT INTO stock (idProduto, type, quantity, cost, date, priceUn)
                VALUES (:idProduct, :type, :quantity, :cost, :date, :priceUn)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $stockMovement->getId());
        $stmt->bindValue(2, $stockMovement->getType());
        $stmt->bindValue(3, $stockMovement->getQuantity());
        $stmt->bindValue(4, $stockMovement->getCost());
        $stmt->bindValue(5, $stockMovement->getDate());
        $stmt->bindValue(6, $stockMovement->getPriceUn());
        $stmt->execute();
    }

    public function getAllBalances(int $idProduct, ?string $dataBalance = null)
    {
        $allBalances = 0;

        $sql = "SELECT quantity FROM stock WHERE idProduto = :idProduct AND type = 'B'";

        if ($dataBalance) {
            $sql .= " AND date = :dataBalance";
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':idProduct', $idProduct, \PDO::PARAM_INT);

        if ($dataBalance) {
            $stmt->bindValue(':dataBalance', $dataBalance, \PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            $allBalances += $stmt->fetchColumn();
        }

        return $allBalances;
    }

    public function getLastDateBalance(int $idProduct)
    {
        $dataBalance = null;

        $sql = "SELECT date FROM stock WHERE idProduto = :idProduct";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':idProduct', $idProduct);

        if ($stmt->execute()) {
            $dataBalance = $stmt->fetchColumn();
        }

        return $dataBalance;
    }
}
