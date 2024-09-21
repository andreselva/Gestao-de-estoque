<?php

namespace Andre\GestaoDeEstoque\Stock\Services;

interface StockServiceInterface
{
    public function processStockMovement(array $data);
    public function searchMovements($idProduto);
}
