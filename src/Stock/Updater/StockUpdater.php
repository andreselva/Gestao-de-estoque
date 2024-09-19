<?php
namespace Andre\GestaoDeEstoque\Stock\Updater;

use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryInterface;

class StockUpdater {
    private $repository;

    public function __construct(StockRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function saveTransaction($StockMovement)
    {
        $this->repository->saveStockMovement($StockMovement);
    }

    public function updateProduct($StockMovement) 
    {
        $dateBalance = $this->repository->getLastDateBalance($StockMovement->getId());
        $lastBalance = $this->repository->getLastBalance($StockMovement->getId(), $dateBalance);
        $entries = $this->repository->getAllEntries($StockMovement->getId(), $dateBalance);
        $exits = $this->repository->getAllExits($StockMovement->getId(), $dateBalance);

        // Calcular o novo estoque e atualizar
        $newStock = ($lastBalance + $entries) - $exits;
        $this->repository->updateStock($StockMovement->getId(), $newStock);
    }

}