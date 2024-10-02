<?php

namespace Andre\GestaoDeEstoque\Stock\CostCalculator\Repository;

interface CostRepositoryInterface
{
    public function getAllCosts(int $idProduct, string $dateBalance): float;
    public function update(int $idProduct, float $newCost): void;
}
