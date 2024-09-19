<?php
namespace Andre\GestaoDeEstoque\Stock\CostCalculator;

use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryInterface;

class CostUpdater {
    private $repository;
    private $calculator;

    public function __construct(StockRepositoryInterface $repository, CostCalculatorInterface $calculator)
    {
        $this->repository = $repository;
        $this->calculator = $calculator;
    }


    public function updateProductCost($StockMovement): void
    {
        $allEntries = 0;
        $allCosts = 0;
        $entriesForCost = $this->repository->getAllEntriesForCost($StockMovement->getId(), $this->repository->getLastDateBalance($StockMovement->getId()));

        foreach ($entriesForCost as $e) {
            $allEntries += $e['quantity'];
            $allCosts += $e['cost'];
        }

        $newCostProduct = $this->calculator->updateCostProduct($allEntries, $allCosts, $StockMovement->getCost());
        $this->repository->updateCostProduct($newCostProduct, $StockMovement->getId());
    }
}