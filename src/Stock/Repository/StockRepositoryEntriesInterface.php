<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

interface StockRepositoryEntriesInterface
{
    public function addEntry(Stock $stockMovement): void;
    public function getEntriesValue(int $idProduto, ?string $dateBalance = null);
    public function getAllEntries($idProduct): array;
}
