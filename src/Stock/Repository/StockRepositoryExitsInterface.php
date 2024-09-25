<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

interface StockRepositoryExitsInterface
{
    public function addExit(Stock $stockMovement): void;
    public function getAllExits(int $idProduct, string $dataBalance = null);
}
