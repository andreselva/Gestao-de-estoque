<?php

namespace Andre\GestaoDeEstoque\Validation;

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
        return preg_replace('/[^a-zA-Z0-9._@-]/', '', $data);
    }
}
