<?php

namespace Andre\GestaoDeEstoque\Stock\Recovery;

use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryBalanceInterface;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryEntriesInterface;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryExitsInterface;

class StockMovementRecovery
{
    private $stockEntries;
    private $stockExits;
    private $stockBalances;

    public function __construct(
        StockRepositoryEntriesInterface $stockEntries,
        StockRepositoryExitsInterface $stockExits,
        StockRepositoryBalanceInterface $stockBalances
    ) {
        $this->stockEntries = $stockEntries;
        $this->stockExits = $stockExits;
        $this->stockBalances = $stockBalances;
    }

    public function getAllMovements($idProduct)
    {
        $entries = $this->stockEntries->getAllEntries($idProduct);
        $exits = $this->stockExits->getAllExits($idProduct);
        $balances = $this->stockBalances->getAllBalances($idProduct);

        $movements = array_merge(...$entries, ...$exits, ...$balances);

        usort($movements, function ($a, $b) {
            return $a['id'] <=> $b['id'];  // Ordenação crescente pelo id
        });

        return $movements;
    }
}
