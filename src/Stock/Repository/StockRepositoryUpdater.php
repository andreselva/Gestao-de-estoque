<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

class StockRepositoryUpdater implements StockRepositoryUpdaterInterface
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function update($idProduct, $newStock = 0): void
    {
        $sql = "UPDATE products SET estoque = :newStock WHERE id = :idProduct";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':newStock', $newStock);
        $stmt->bindValue(':idProduct', $idProduct);
        $stmt->execute();
    }
}
