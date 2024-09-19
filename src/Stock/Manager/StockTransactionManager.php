<?php
namespace Andre\GestaoDeEstoque\Stock\Manager;

use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryInterface;

class StockTransactionManager
{
    private $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function execute(callable $transaction)
    {
        $this->stockRepository->executeTransaction($transaction);
    }
}
