<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

interface StockRepositoryUpdaterInterface
{
    public function update($idProduct, $newStock = 0): void;
}
