<?php

namespace Andre\GestaoDeEstoque\Stock\Services;

use Exception;
use InvalidArgumentException;
use Andre\GestaoDeEstoque\Stock\Factorys\StockFactory;
use Andre\GestaoDeEstoque\Stock\Manager\StockRepositoryManager;
use Andre\GestaoDeEstoque\Parameters\ParametersRepositoryInterface;
use Andre\GestaoDeEstoque\Stock\CostCalculator\Services\CostServiceCalculatorInterface;
use Andre\GestaoDeEstoque\Stock\Recovery\StockMovementRecovery;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryExitsInterface;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryBalanceInterface;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryEntriesInterface;

class StockService implements StockServiceInterface
{
    private $parameters;
    private $manager;
    private $stockEntry;
    private $stockExit;
    private $stockBalance;
    private $stockCalculator;
    private $costCalculator;
    private const MOV_ENTRY = 'E';
    private const MOV_EXIT = 'S';
    private const MOV_BALANCE = 'B';

    public function __construct(
        ParametersRepositoryInterface $parameters,
        StockRepositoryManager $manager,
        StockRepositoryEntriesInterface $stockEntry,
        StockRepositoryExitsInterface $stockExit,
        StockRepositoryBalanceInterface $stockBalance,
        StockServiceCalculatorInterface $stockCalculator,
        CostServiceCalculatorInterface $costCalculator
    ) {
        $this->parameters = $parameters;
        $this->manager = $manager;
        $this->stockEntry = $stockEntry;
        $this->stockExit = $stockExit;
        $this->stockBalance = $stockBalance;
        $this->stockCalculator = $stockCalculator;
        $this->costCalculator = $costCalculator;
    }

    public function processStockMovement(array $data): void
    {
        try {
            $StockMovement = StockFactory::create($data);

            $this->manager->executeTransaction(function () use ($StockMovement) {


                if ($StockMovement->getType() === self::MOV_ENTRY) {
                    $paramCost = $this->parameters->getValueParam('controlaCusto');

                    if ($paramCost == 1) {
                        if ($StockMovement->getCost() == '' || $StockMovement->getCost() == 0) {
                            $this->costCalculator->calculateForEntry($StockMovement);
                        }
                    }

                    $this->stockEntry->addEntry($StockMovement);

                    if ($paramCost == 1) {
                        $this->costCalculator->calculateTheNewProductCost($StockMovement->getId());
                    }
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
            $recovery = new StockMovementRecovery($this->stockEntry, $this->stockExit, $this->stockBalance);
            return $recovery->getAllMovements($idProduto);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException('An error ocurred', 0, $e);
        }
    }
}
