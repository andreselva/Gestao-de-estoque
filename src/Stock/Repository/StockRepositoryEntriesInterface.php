<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

interface StockRepositoryEntriesInterface
{
    public function addEntry(Stock $stockMovement): void;
    public function getAllEntries(int $idProduto, ?string $dateBalance = null);
}
