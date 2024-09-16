<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

class StockRepository implements StockRepositoryInterface
{

    private $connection;

    public function __construct($connection) 
    {
        $this->connection = $connection;
    }

    public function SaveStockMovement(Stock $launch) {}
}
