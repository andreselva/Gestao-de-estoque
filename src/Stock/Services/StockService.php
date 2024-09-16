<?php

namespace Andre\GestaoDeEstoque\Stock\Services;

use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryInterface;
use Andre\GestaoDeEstoque\Validation\DataSanitizer;

class StockService implements StockServiceInterface {

    private $stockRepository;
    private $sanitizer;

    public function __construct(StockRepositoryInterface $stockRepository, DataSanitizer $sanitizer)
    {
        $this->stockRepository = $stockRepository;
        $this->sanitizer = $sanitizer;
    }

    public function MoveForwardStockMovement(array $data)
    {
        $this->sanitizer->StockSanitizer($data);
    }

}