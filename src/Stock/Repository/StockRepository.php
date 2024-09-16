<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

class StockRepository implements StockRepositoryInterface
{
    public function __construct() {}

    public function SaveStockMovement(Stock $launch) {}
}
