<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;
use Exception;

class StockRepositoryEntries implements StockRepositoryEntriesInterface
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function addEntry(Stock $stockMovement): void
    {
        $sql = "INSERT INTO stock (idProduto, type, quantity, cost, date, priceUn) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $stockMovement->getId());
        $stmt->bindValue(2, $stockMovement->getType());
        $stmt->bindValue(3, $stockMovement->getQuantity());
        $stmt->bindValue(4, $stockMovement->getCost());
        $stmt->bindValue(5, $stockMovement->getDate());
        $stmt->bindValue(6, $stockMovement->getPriceUn());
        $stmt->execute();
    }

    public function getEntriesValue(int $idProduct, ?string $dataBalance = null)
    {
        try {
            $allEntries = 0;

            $sql = "SELECT * FROM stock WHERE idProduto = :idProduct AND type = 'E'";

            if ($dataBalance) {
                $sql .= " AND date >= :dataBalance";
            }

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':idProduct', $idProduct, \PDO::PARAM_INT);

            if ($dataBalance) {
                $stmt->bindValue(':dataBalance', $dataBalance, \PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $entries = $stmt->fetchAll(\PDO::FETCH_ASSOC); // Obtém todos os registros
                $allEntries = array_sum(array_column($entries, 'quantity'));
            }

            return $allEntries;
        } catch (Exception $e) {
            throw new Exception('An error occurred while getting all entries');
        }
    }

    public function getAllEntries($idProduct): array
    {
        try {
            $entries = [];

            $sql = "SELECT * FROM stock WHERE idProduto = :idProduct AND type = 'E'";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':idProduct', $idProduct);

            if ($stmt->execute()) {
                $entries[] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $entries;
            }

            return $entries;

        } catch (Exception $e) {
        }
    }
}
