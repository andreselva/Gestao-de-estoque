<?php

namespace Andre\GestaoDeEstoque\Validation;

use DateTime;
use InvalidArgumentException;

class DataSanitizer
{
    public function __construct() {}

    public function productSanitizer(array $data): array
    {
        $sanitizedData = [
            'name' => $this->sanitizeName($data['name']),
            'codigo' => $this->sanitize($data['codigo']),
            'dataCriacao' => (new DateTime())->format('Y-m-d H:i:s'),
            'precoVenda' => $this->sanitizeDecimal($data['preco-venda']) ?? 0,
            'un' => $this->sanitize($data['un']),
            'pesoBruto' => $this->sanitizeDecimal($data['peso-bruto']),
            'pesoLiquido' => $this->sanitizeDecimal($data['peso-liquido']),
            'gtin' => $this->sanitize($data['gtin']),
        ];

        if (isset($data['idProduto'])) {
            $sanitizedData['id'] = $this->sanitize($data['idProduto']);
        }

        if ($sanitizedData['precoVenda'] <= 0) {
            throw new \InvalidArgumentException('Price cannot be negative or equal to zero.');
        }

        if ($sanitizedData['pesoBruto'] < 0 || $sanitizedData['pesoLiquido'] < 0) {
            throw new \InvalidArgumentException('Gross weight or net weight cannot be less than zero.');
        }

        return $sanitizedData;
    }

    public function stockSanitizer(array $data): array
    {
        return [
            'id' => $this->sanitizeInt($data['idProduto']),
            'type' => $this->sanitize($data['type']),
            'cost' => $this->sanitizeDecimal($data['cost']),
            'quantity' => $this->sanitizeInt($data['quantity'])
        ];
    }

    /**
     * Realiza a limpeza dos dados
     * 
     * @param string $data
     * @return string
     */
    public function sanitize($data): string
    {
        if (empty($data)) {
            throw new \InvalidArgumentException($data . ' cannot be empty.');
        }

        return preg_replace('/[^a-zA-Z0-9._@-]/', '', $data);
    }

    public function sanitizeName($name): string
    {
        if (empty($name)) {
            throw new \InvalidArgumentException($name . 'cannot be empty.');
        }

        return preg_replace('/[^a-zA-ZÀ-ÿ0-9 ]/', '', $name);
    }

    public function sanitizeDecimal(string $data): string
    {
        // Remove qualquer caractere que não seja número, ponto ou vírgula
        $sanitizedData = preg_replace('/[^0-9.,-]/', '', $data);

        // Substitui vírgula por ponto, caso exista, para garantir o formato de decimal
        $sanitizedData = str_replace(',', '.', $sanitizedData);

        // Retorna o valor como string, pois decimal pode ter alta precisão (mantém o formato)
        return number_format((float)$sanitizedData, 2, '.', '');
    }

    private function sanitizeInt(string $data): int
    {
        return (int) $data;
    }
}
