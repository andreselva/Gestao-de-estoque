<?php

namespace Andre\GestaoDeEstoque\Stock\Validation;

use Andre\GestaoDeEstoque\Stock\Validation\StockValidator;

class StockSanitizer
{
    private $stockValidator;

    public function __construct(StockValidator $stockValidator)
    {
        $this->stockValidator = $stockValidator;
    }

    public function sanitizer(array $data): void
    {
        $dataSanitize = [
            'idProduto' => $this->sanitizeInt($data['idProduto']),
            'type' => $this->sanitize($data['type']),
            'cost' => $this->sanitizeDecimal($data['cost']),
            'quantity' => $this->sanitizeInt($data['quantity']),
            'priceUn' => $this->sanitizeDecimal($data['price-un'])
        ];

        $this->stockValidator->validate($dataSanitize);
    }

    public function sanitizeSearchMovements($data)
    {
        $dataSanitize = [
            'idProduto' => $this->sanitizeInt($data['idProduto'])
        ];

        return $this->stockValidator->validateIdProduct($dataSanitize);
    }

    private function sanitizeInt($data)
    {
        // Verifica se é um número antes de converter
        if (is_numeric($data)) {
            return (int)$data; // Converte para inteiro
        }

        return 0; // Retorna 0 se não for numérico
    }

    private function sanitize($data)
    {
        return preg_replace('/[^a-zA-Z0-9._@-]/', '', $data);
    }

    private function sanitizeDecimal($data)
    {
        // Remove qualquer caractere que não seja número, ponto ou vírgula
        $sanitizedData = preg_replace('/[^0-9.,-]/', '', $data);

        // Substitui vírgula por ponto, caso exista, para garantir o formato de decimal
        $sanitizedData = str_replace(',', '.', $sanitizedData);

        // Retorna o valor como string, pois decimal pode ter alta precisão (mantém o formato)
        return number_format((float)$sanitizedData, 2, '.', '');
    }
}
