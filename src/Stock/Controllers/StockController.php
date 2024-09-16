<?php

namespace Andre\GestaoDeEstoque\Stock\Controllers;

use Andre\GestaoDeEstoque\Stock\Services\StockServiceInterface;

class StockController
{

    private $stockService;

    public function __construct(StockServiceInterface $stockService)
    {
        $this->stockService = $stockService;
    }

    public function getStockMovement(array $data) {}
}
