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
            $result = $this->stockRepository->SaveStockMovement($StockMovement);

            if ($result) {
                $dateBalance = $this->stockRepository->getLastDateBalance($StockMovement->getId());
                $lastBalance = $this->stockRepository->getLastBalance($StockMovement->getId(), $dateBalance);
                $entrances = $this->stockRepository->getAllEntrances($StockMovement->getId(), $dateBalance);
                $exits = $this->stockRepository->getAllExits($StockMovement->getId(), $dateBalance);

                $newStock = $this->calculateNewStock($lastBalance, $entrances, $exits);
                $this->stockRepository->updateStock($StockMovement->getId(), $newStock);
            }
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException('An error occurred while moving stock', 0, $e);
        } catch (\Exception $e) {
            throw new Exception('An error occurred when trying to insert movement', 0, $e);
        }
    }

    private function calculateNewStock($lastBalance, $entrances, $exits)
    {
        $stock = ($lastBalance + $entrances) - $exits;
        return $stock !== '' ? $stock : 0;
    }
}
