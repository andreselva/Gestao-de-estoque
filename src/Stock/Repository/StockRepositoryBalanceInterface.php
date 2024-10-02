<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

interface StockRepositoryBalanceInterface
{
    public function addBalance(Stock $stockMovement): void;
    public function getBalanceValue(int $idProduct);
    public function getLastDateBalance(int $idProduct);
    public function getAllBalances(?int $idProduct = null);
}
