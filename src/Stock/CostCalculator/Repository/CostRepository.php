<?php

namespace Andre\GestaoDeEstoque\Stock\CostCalculator\Repository;

use Exception;

class CostRepository implements CostRepositoryInterface
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getAllCosts(int $idProduct, string $dateBalance = null): float
    {
        $totalCost = 0;

        $sql = "SELECT * FROM stock WHERE idProduto = :idProduct";

        if ($dateBalance) {
            $sql .= " AND date >= :dateBalance";
            $sql .= " AND type in ('E', 'B')";
        } else {
            $sql .= " AND type = 'E'";
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':idProduct', $idProduct);

        if ($dateBalance) {
            $stmt->bindValue('dateBalance', $dateBalance);
        }

        if ($stmt->execute()) {
            $costs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($costs as $cost) {
                $totalCost += ($cost['quantity'] * $cost['priceUn']);
            }
        }

        return $totalCost;
    }

    public function update(int $idProduct, float $newCost): void
    {
        try {
            $sql = "UPDATE products SET cost = :newCost WHERE id = :idProduct";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':newCost', $newCost);
            $stmt->bindValue(':idProduct', $idProduct);
            $stmt->execute();
        } catch (Exception $e) {
        }
    }
}
