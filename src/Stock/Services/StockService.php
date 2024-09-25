<?php

namespace Andre\GestaoDeEstoque\Stock\Services;

use Exception;
use InvalidArgumentException;
use Andre\GestaoDeEstoque\Stock\Updater\StockUpdater;
use Andre\GestaoDeEstoque\Stock\Factorys\StockFactory;
use Andre\GestaoDeEstoque\Stock\CostCalculator\CostUpdater;
use Andre\GestaoDeEstoque\Stock\Manager\StockRepositoryManager;
use Andre\GestaoDeEstoque\Stock\Processor\StockMovementProcessor;
use Andre\GestaoDeEstoque\Parameters\ParametersRepositoryInterface;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryExitsInterface;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryBalanceInterface;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryEntriesInterface;

class StockService implements StockServiceInterface
{
    private $parameters;
    private $manager;
    private $processor;
    private $stockEntry;
    private $stockExit;
    private $stockBalance;
    private $stockCalculator;
    private const MOV_ENTRY = 'E';
    private const MOV_EXIT = 'S';
    private const MOV_BALANCE = 'B';

    public function __construct(
        ParametersRepositoryInterface $parameters,
        StockRepositoryManager $manager,
        StockMovementProcessor $processor,
        StockRepositoryEntriesInterface $stockEntry,
        StockRepositoryExitsInterface $stockExit,
        StockRepositoryBalanceInterface $stockBalance,
        StockServiceCalculatorInterface $stockCalculator
    ) {
        $this->parameters = $parameters;
        $this->manager = $manager;
        $this->processor = $processor;
        $this->stockEntry = $stockEntry;
        $this->stockExit = $stockExit;
        $this->stockBalance = $stockBalance;
        $this->stockCalculator = $stockCalculator;
    }

    public function processStockMovement(array $data): void
    {
        try {
            $StockMovement = StockFactory::create($data);

            $this->manager->executeTransaction(function () use ($StockMovement) {
                $paramCost = $this->parameters->getValueParam('controlaCusto');

                if ($paramCost == '1') {
                    $this->processor->process($StockMovement);
                }

                if ($StockMovement->getType() === self::MOV_ENTRY) {
                    $this->stockEntry->addEntry($StockMovement);
                } else if ($StockMovement->getType() === self::MOV_EXIT) {
                    $this->stockExit->addExit($StockMovement);
                } else if ($StockMovement->getType() === self::MOV_BALANCE) {
                    $this->stockBalance->addBalance($StockMovement);
                }

                $this->stockCalculator->calculateNewStock($StockMovement->getId());
                
            });
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException('An error occurred while moving stock', 0, $e);
        } catch (\Exception $e) {
            throw new Exception('An error occurred when trying to insert movement', 0, $e);
        }
    }

    public function searchMovements($idProduto)
    {
        try {
            return $this->manager->executeSearch($idProduto);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException('An error ocurred', 0, $e);
        }
    }
}
