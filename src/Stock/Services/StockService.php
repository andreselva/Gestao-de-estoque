<?php

namespace Andre\GestaoDeEstoque\Stock\Services;

use Andre\GestaoDeEstoque\Stock\Factorys\StockFactory;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryInterface;
use Andre\GestaoDeEstoque\Validation\DataSanitizer;
use Andre\GestaoDeEstoque\Validation\StockValidator;
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
            $this->sanitizer->StockSanitizer($data);
            $this->validator->validate($data);

            if ($data['type'] === 'S') {
                $data['quantity'] *= -1;
            }

            if ($data['cost'] === '') {
                $data['cost'] = 0;
            }

            $StockMovement = StockFactory::create($data);
            $this->stockRepository->SaveStockMovement($StockMovement);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException('An error occurred while moving stock', 0, $e);
        } catch (\Exception $e) {
            throw new Exception('An error occurred when trying to insert movement', 0, $e);
        }
    }
}
