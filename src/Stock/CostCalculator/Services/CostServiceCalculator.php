<?php

namespace Andre\GestaoDeEstoque\Stock\CostCalculator\Services;

use Andre\GestaoDeEstoque\Stock\CostCalculator\Repository\CostRepositoryInterface;
use Andre\GestaoDeEstoque\Stock\Entity\Stock;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryBalanceInterface;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryEntriesInterface;

class CostServiceCalculator implements CostServiceCalculatorInterface
{
    private $stockEntries;
    private $stockBalance;
    private $costRepository;

    public function __construct(
        StockRepositoryEntriesInterface $stockEntries,
        StockRepositoryBalanceInterface $stockBalance,
        CostRepositoryInterface $costRepository
    ) {
        $this->stockEntries = $stockEntries;
        $this->stockBalance = $stockBalance;
        $this->costRepository = $costRepository;
    }

    public function calculateForEntry(Stock $movement)
    {
        $costMovement = ($movement->getQuantity() * $movement->getPriceUn()) / $movement->getQuantity();
        $movement->setCost($costMovement);
    }

    public function calculateTheNewProductCost(int $idProduct)
    {
        $lastDateBalance = $this->stockBalance->getLastDateBalance($idProduct);
        $balanceValue = $this->stockBalance->getBalanceValue($idProduct);
        $allEntries = $this->stockEntries->getEntriesValue($idProduct, $lastDateBalance) + $balanceValue;
        $allCosts = $this->costRepository->getAllCosts($idProduct, $lastDateBalance);
        $newCost = $this->calculate($allEntries, $allCosts);
        $this->costRepository->update($idProduct, $newCost);
    }

    private function calculate($allEntries = 0, $allCosts = 0)
    {
        return $allCosts / $allEntries;
    }
}
