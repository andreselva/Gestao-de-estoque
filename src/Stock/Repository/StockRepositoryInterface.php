<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

interface StockRepositoryInterface
{
    public function saveStockMovement(Stock $launch);
    public function getLastDateBalance($idProduto);
    public function getLastBalance($idProduto, $dataBalanco);
    public function getAllEntries($idProduto, $dataBalanco);
    public function getAllExits($idProduto, $dataBalanco);
    public function updateStock($idProduto, $novoEstoque);
    public function getAllEntriesForCost($idProduto, $dataBalanco);
    public function updateCostProduct($newCost, $idProduto);
    public function searchMovements($idProduto): array;
}
