<?php

namespace Andre\GestaoDeEstoque\Stock\CostCalculator;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

interface CostCalculatorInterface
{
    public function calculateByItem($idProduto, $entrance, $precoUn);
    public function updateCostProduct(int $allEntries, float $allCosts, float $cost);
}
