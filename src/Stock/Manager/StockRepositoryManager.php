<?php

namespace Andre\GestaoDeEstoque\Stock\Manager;

use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryInterface;

class StockRepositoryManager
{
    private $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function executeTransaction(callable $transaction)
    {
        $this->stockRepository->executeTransaction($transaction);
    }

    public function executeSearch(int $idProduto): array
    {
        return $this->stockRepository->searchMovements($idProduto);
    }
}
