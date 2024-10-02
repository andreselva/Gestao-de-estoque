<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;
use Exception;

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
        $stmt->bindValue(':idProduct', $stockMovement->getId());
        $stmt->bindValue(':type', $stockMovement->getType());
        $stmt->bindValue(':quantity', $stockMovement->getQuantity());
        $stmt->bindValue(':cost', $stockMovement->getCost());
        $stmt->bindValue(':date', $stockMovement->getDate());
        $stmt->bindValue(':priceUn', $stockMovement->getPriceUn());
        $stmt->execute();
    }

    public function getBalanceValue(int $idProduct)
    {
        $balanceValue = 0;
        $dataBalance = $this->getLastDateBalance($idProduct);

        if ($dataBalance) {
            $sql = "SELECT quantity FROM stock WHERE idProduto = :idProduct AND type = 'B' AND date = :dataBalance";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':idProduct', $idProduct, \PDO::PARAM_INT);
            $stmt->bindValue(':dataBalance', $dataBalance, \PDO::PARAM_STR);
            if ($stmt->execute()) {
                $balanceValue += $stmt->fetchColumn();
            }

            return $balanceValue;
        }

        return $balanceValue;
    }

    public function getLastDateBalance(int $idProduct)
    {
        $dataBalance = null;

        $sql = "SELECT date FROM stock WHERE idProduto = :idProduct AND type = 'B' ORDER BY date DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':idProduct', $idProduct);

        if ($stmt->execute()) {
            $dataBalance = $stmt->fetchColumn();
        }

        return $dataBalance;
    }

    public function getAllBalances(?int $idProduct = null)
    {
        $balances = [];
        try {

            $sql = "SELECT * FROM stock WHERE type = 'B' AND idProduto = :idProduct";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':idProduct', $idProduct);

            if ($stmt->execute()) {
                $balances[] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $balances;
            }

            return $balances;
        } catch (Exception $e) {
        }
    }
}
