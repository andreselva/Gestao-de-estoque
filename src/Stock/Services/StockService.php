<?php

namespace Andre\GestaoDeEstoque\Stock\Services;

use Andre\GestaoDeEstoque\Stock\Factorys\StockFactory;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryInterface;
use Andre\GestaoDeEstoque\Validation\DataSanitizer;
use Andre\GestaoDeEstoque\Stock\Validator\StockValidator;
use Exception;
use InvalidArgumentException;

class StockService implements StockServiceInterface
{

    private $stockRepository;
    private $sanitizer;
    private $validator;

    public function __construct(StockRepositoryInterface $stockRepository, DataSanitizer $sanitizer, StockValidator $validator)
    {
        $this->stockRepository = $stockRepository;
        $this->sanitizer = $sanitizer;
        $this->validator = $validator;

        set_error_handler(function ($severity, $message, $file, $line) {
            // Lançar uma exceção com os detalhes do erro
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });
    }

    public function processStockMovement(array $data): void
    {
        try {
            $this->sanitizer->stockSanitizer($data);
            $this->validator->validate($data);

            if ($data['cost'] === '') {
                $data['cost'] = 0;
            }

            $StockMovement = StockFactory::create($data);
            $this->stockRepository->executeTransaction(function () use ($StockMovement) {
                // Salvar movimento de estoque
                $this->stockRepository->saveStockMovement($StockMovement);

                // Obter dados para o cálculo do novo estoque
                $dateBalance = $this->stockRepository->getLastDateBalance($StockMovement->getId());
                $lastBalance = $this->stockRepository->getLastBalance($StockMovement->getId(), $dateBalance);
                $entrances = $this->stockRepository->getAllEntrances($StockMovement->getId(), $dateBalance);
                $exits = $this->stockRepository->getAllExits($StockMovement->getId(), $dateBalance);

                // Calcular o novo estoque e atualizar
                $newStock = $this->calculateNewStock($lastBalance, $entrances, $exits);
                $this->stockRepository->updateStock($StockMovement->getId(), $newStock);
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
