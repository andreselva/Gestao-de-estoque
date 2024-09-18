<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;
use Exception;

class StockRepository implements StockRepositoryInterface
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function SaveStockMovement(Stock $launch)
    {
        try {
            $sql = "INSERT INTO stock (idProduto, type, quantity, cost, date) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $launch->getId());
            $stmt->bindValue(2, $launch->getType());
            $stmt->bindValue(3, $launch->getQuantity());
            $stmt->bindValue(4, $launch->getCost());
            $stmt->bindValue(5, $launch->getDate());
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('An error occurred while saving the stock movement', 0, $e);
        }
    }
}
