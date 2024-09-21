<?php

namespace Andre\GestaoDeEstoque\Stock\Services;

use Andre\GestaoDeEstoque\Parameters\ParametersRepositoryInterface;
use Andre\GestaoDeEstoque\Stock\CostCalculator\CostUpdater;
use Andre\GestaoDeEstoque\Stock\Factorys\StockFactory;
use Andre\GestaoDeEstoque\Stock\Manager\StockRepositoryManager;
use Andre\GestaoDeEstoque\Stock\Processor\StockMovementProcessor;
use Andre\GestaoDeEstoque\Stock\Updater\StockUpdater;
use Exception;
use InvalidArgumentException;

class StockService implements StockServiceInterface
{
    private $parameters;
    private $manager;
    private $movementProcessor;
    private $stockUpdater;
    private $costUpdater;
    private const MOVE_STOCK = 'E';

    public function __construct(
        ParametersRepositoryInterface $parameters,
        StockRepositoryManager $manager,
        StockMovementProcessor $movementProcessor,
        StockUpdater $stockUpdater,
        CostUpdater $costUpdater
    ) {
        $this->parameters = $parameters;
        $this->manager = $manager;
        $this->movementProcessor = $movementProcessor;
        $this->stockUpdater = $stockUpdater;
        $this->costUpdater = $costUpdater;
    }

    public function processStockMovement(array $data): void
    {
        try {
            $StockMovement = StockFactory::create($data);

            $this->manager->executeTransaction(function () use ($StockMovement) {
                $paramCost = $this->parameters->getValueParam('controlaCusto');

                if ($StockMovement->getType() === self::MOVE_STOCK && $paramCost === 1) {
                    $this->movementProcessor->process($StockMovement);
                    $this->costUpdater->updateProductCost($StockMovement);
                }

                $this->stockUpdater->saveTransaction($StockMovement);
                $this->stockUpdater->updateProduct($StockMovement);
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
