<?php

namespace Andre\GestaoDeEstoque\Stock\Services;

interface StockServiceInterface
{
    public function MoveForwardStockMovement(array $data);
}
