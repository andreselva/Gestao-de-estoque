<?php

namespace Andre\GestaoDeEstoque\Stock\Services;

interface StockServiceInterface
{
    public function processStockMovement(array $data);
}
