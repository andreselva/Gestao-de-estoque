<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;
use Exception;

class StockRepositoryExits implements StockRepositoryExitsInterface
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function addExit(Stock $stockMovement): void
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

    public function getAllExits(int $idProduct, ?string $dataBalance = null)
    {
        try {
            $allExits = 0;

            $sql = "SELECT * FROM stock WHERE idProduto = :idProduct AND type = 'S'";

            if ($dataBalance) {
                $sql .= " AND date >= :dataBalance";
            }

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':idProduct', $idProduct, \PDO::PARAM_INT);

            if ($dataBalance) {
                $stmt->bindValue(':dataBalance', $dataBalance, \PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $exits = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($exits as $exit) {
                    $allExits += $exit['quantity'];
                }
            }

            return $allExits;
        } catch (Exception $e) {
        }
    }
}
