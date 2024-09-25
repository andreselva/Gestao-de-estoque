<?php

namespace Andre\GestaoDeEstoque\Stock\Services;

interface StockServiceCalculatorInterface
{
    public function calculateNewStock(int $idProduct): void;
}
