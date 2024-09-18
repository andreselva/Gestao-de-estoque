<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

interface StockRepositoryInterface
{
    public function executeTransaction(callable $operations);
    public function saveStockMovement(Stock $launch);
    public function getLastDateBalance($idProduto);
    public function getLastBalance($idProduto, $dataBalanco);
    public function getAllEntrances($idProduto, $dataBalanco);
    public function getAllExits($idProduto, $dataBalanco);
    public function updateStock($idProduto, $novoEstoque);
}
