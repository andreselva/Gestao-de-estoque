<?php

namespace Andre\GestaoDeEstoque\Stock\Services;

use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryBalanceInterface;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryEntriesInterface;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryExitsInterface;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryUpdaterInterface;

class StockServiceCalculator implements StockServiceCalculatorInterface
{
    private $stockEntries;
    private $stockExits;
    private $stockBalances;
    private $stockRepositoryUpdater;

    public function __construct(
        StockRepositoryEntriesInterface $stockEntries,
        StockRepositoryExitsInterface $stockExits,
        StockRepositoryBalanceInterface $stockBalances,
        StockRepositoryUpdaterInterface $stockRepositoryUpdater
    ) {
        $this->stockEntries = $stockEntries;
        $this->stockExits = $stockExits;
        $this->stockBalances = $stockBalances;
        $this->stockRepositoryUpdater = $stockRepositoryUpdater;
    }

    public function calculateNewStock(int $idProduct): void
    {
        $lastDateBalance = $this->stockBalances->getLastDateBalance($idProduct);
        $balance = $this->stockBalances->getBalanceValue($idProduct, $lastDateBalance);
        $entries = $this->stockEntries->getAllEntries($idProduct, $lastDateBalance);
        $exits = $this->stockExits->getAllExits($idProduct, $lastDateBalance);

        $newStock = $this->calculate($balance, $entries, $exits);
        $this->stockRepositoryUpdater->update($idProduct, $newStock);
    }

    private function calculate($balance = 0, $entries = 0, $exits = 0)
    {
        return ($balance + $entries) - $exits;
    }
}
