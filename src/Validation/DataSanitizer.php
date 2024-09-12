<?php

namespace Andre\GestaoDeEstoque\Validation;

use InvalidArgumentException;

class DataSanitizer
{
    public function __construct() {}


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
}
