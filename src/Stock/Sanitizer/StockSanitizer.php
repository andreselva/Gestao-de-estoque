<?php

namespace Andre\GestaoDeEstoque\Stock\Sanitizer;

use Andre\GestaoDeEstoque\Stock\Services\StockServiceInterface;

class StockSanitizer implements StockSanitizerInterface
{
    public function sanitizer(array $data): array
    {
        return [
            'id' => $this->sanitizeInt($data['idProduto']),
            'type' => $this->sanitize($data['type']),
            'cost' => $this->sanitizeDecimal($data['cost']),
            'quantity' => $this->sanitizeInt($data['quantity'])
        ];
    }

    private function sanitizeInt($data)
    {
        return (int) $data;
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
