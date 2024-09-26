<?php

namespace Andre\GestaoDeEstoque\Stock\CostCalculator\Services;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

interface CostServiceCalculatorInterface
{
    public function calculateForEntry(Stock $movement);
    public function calculateTheNewProductCost(int $idProduct);
}
