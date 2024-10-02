<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

interface StockRepositoryExitsInterface
{
    public function addExit(Stock $stockMovement): void;
    public function getExitsValue(int $idProduct, string $dataBalance = null);
    public function getAllExits($idProduct): array;
}
