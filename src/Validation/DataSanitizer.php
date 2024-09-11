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
    public function sanitize($data)
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Data cannot be empty');
        }

        return preg_replace('/[^a-zA-Z0-9._@-]/', '', $data);
    }
}
