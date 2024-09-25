<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

interface StockRepositoryBalanceInterface
{
    public function addBalance(Stock $stockMovement): void;
    public function getAllBalances(int $idProduct, ?string $dataBalance = null);
    public function getLastDateBalance(int $idProduct);
}
