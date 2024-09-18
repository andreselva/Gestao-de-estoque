<?php

namespace Andre\GestaoDeEstoque\Stock\Services;

use Andre\GestaoDeEstoque\Parameters\ParametersRepositoryInterface;
use Andre\GestaoDeEstoque\Stock\CostCalculator\CostCalculatorInterface;
use Andre\GestaoDeEstoque\Stock\Factorys\StockFactory;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryInterface;
use Exception;
use InvalidArgumentException;

class StockService implements StockServiceInterface
{

    private $stockRepository;
    private $parameters;
    private $costCalculator;

    public function __construct(StockRepositoryInterface $stockRepository, ParametersRepositoryInterface $parameters, CostCalculatorInterface $costCalculator)
    {
        $this->stockRepository = $stockRepository;
        $this->parameters = $parameters;
        $this->costCalculator = $costCalculator;

        set_error_handler(function ($severity, $message, $file, $line) {
            // Lançar uma exceção com os detalhes do erro
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });
    }

    public function processStockMovement(array $data): void
    {
        try {
            $StockMovement = StockFactory::create($data);
            $this->stockRepository->executeTransaction(function () use ($StockMovement) {

                // Verifica se é tipo entrada. Se for, verifica o valor do parâmetro. 
                // Se for 1, verifica se o custo já não foi informado no lançamento, se não foi, calcula.
                if ($StockMovement->getType() === 'E') {
                    $calculateCost = $this->parameters->getValueParam('controlaCusto');
                    if ($calculateCost === 1) {
                        if ($StockMovement->getCost() == '' || $StockMovement->getCost() == 0) {
                            $cost = $this->costCalculator->calculateByItem(
                                $StockMovement->getId(),
                                $StockMovement->getQuantity(),
                                $StockMovement->getPriceUn()
                            );
                            $StockMovement->setCost($cost);
                        }
                    }
                }
                // Salvar movimento de estoque
                $this->stockRepository->saveStockMovement($StockMovement);

                // Obter dados para o cálculo do novo estoque
                $dateBalance = $this->stockRepository->getLastDateBalance($StockMovement->getId());
                $lastBalance = $this->stockRepository->getLastBalance($StockMovement->getId(), $dateBalance);
                $entries = $this->stockRepository->getAllEntries($StockMovement->getId(), $dateBalance);
                $exits = $this->stockRepository->getAllExits($StockMovement->getId(), $dateBalance);

                // Calcular o novo estoque e atualizar
                $newStock = $this->calculateNewStock($lastBalance, $entries, $exits);
                $this->stockRepository->updateStock($StockMovement->getId(), $newStock);

                if ($calculateCost === 1) {
                    $allEntries = 0;
                    $allCosts = 0;
                    $entriesForCost = $this->stockRepository->getAllEntriesForCost($StockMovement->getId(), $dateBalance);

                    foreach ($entriesForCost as $e) {
                        $allEntries += $e['quantity'];
                        $allCosts += $e['cost'];
                    }

                    $newCostProduct = $this->costCalculator->updateCostProduct($allEntries, $allCosts, $cost);
                    $this->stockRepository->updateCostProduct($newCostProduct, $StockMovement->getId(),);
                }
            });
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException('An error occurred while moving stock', 0, $e);
        } catch (\Exception $e) {
            throw new Exception('An error occurred when trying to insert movement', 0, $e);
        }
    }

    private function calculateNewStock($lastBalance, $entrances, $exits)
    {
        try {
            $stock = ($lastBalance + $entrances) - $exits;
            return $stock !== '' ? $stock : 0;
        } catch (Exception $e) {
            throw new Exception('An error ocurred during update stock.');
        }
    }
}
