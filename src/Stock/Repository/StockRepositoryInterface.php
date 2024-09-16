<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

interface StockRepositoryInterface
{
    public function SaveStockMovement(Stock $launch);
}
