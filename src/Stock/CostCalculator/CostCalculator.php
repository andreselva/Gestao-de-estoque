<?php

namespace Andre\GestaoDeEstoque\Stock\CostCalculator;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;

class CostCalculator implements CostCalculatorInterface
{
    public function calculateByItem($idProduto, $entrance, $precoUn)
    {
        $costMovement = ($entrance * $precoUn) / $entrance;
        return $costMovement;
    }

    public function updateCostProduct(int $allEntries, float $allCosts, float $cost)
    {
        $newCostProduct = (($allEntries * $allCosts) / $allEntries) + $cost;
        return $newCostProduct;
    }
}
