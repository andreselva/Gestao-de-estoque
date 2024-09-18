<?php

namespace Andre\GestaoDeEstoque\Stock\Validation;

use Andre\GestaoDeEstoque\Stock\Services\StockServiceInterface;
use InvalidArgumentException;

class StockValidator
{
    private $stockService;

    public function __construct(StockServiceInterface $stockService)
    {
        $this->stockService =  $stockService;
    }

    public function validate(array $data): void
    {
        // Verifica se as chaves necessárias estão presentes no array
        if (!isset($data['idProduto'], $data['type'], $data['quantity'], $data['cost'], $data['priceUn'])) {
            throw new InvalidArgumentException('Missing required fields.');
        }

        // Verifica o idProduto
        if (in_array($data['idProduto'], ['', 0], true)) {
            throw new InvalidArgumentException('The product identifier is invalid.');
        }

        // Verifica o tipo
        if (!in_array($data['type'], ['S', 'E', 'B'], true)) {
            throw new InvalidArgumentException('The movement type is not valid.');
        }

        // Verifica a quantidade
        if ($data['quantity'] < 0 || $data['quantity'] === '') {
            throw new InvalidArgumentException('The quantity cannot be less than zero or empty.');
        }

        // Verifica o custo se estiver presente
        if (!empty($data['cost']) && $data['cost'] < 0) {
            throw new InvalidArgumentException('The cost cannot be less than zero.');
        }

        if (!empty($data['priceUn'] && $data['priceUn'] < 0)) {
            throw new InvalidArgumentException('The price cannot be less than zero.');
        }

        if ($data['cost'] === '') {
            $data['cost'] = 0;
        }

        if ($data['priceUn'] === '') {
            $data['priceUn'] = 0;
        }

        $this->stockService->processStockMovement($data);
    }
}
