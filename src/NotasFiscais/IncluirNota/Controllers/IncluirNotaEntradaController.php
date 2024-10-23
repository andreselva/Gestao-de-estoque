<?php

namespace Andre\GestaoDeEstoque\NotasFiscais\IncluirNota\Controllers;

use Andre\GestaoDeEstoque\NotasFiscais\IncluirNota\Services\IncluirNotaEntradaServiceInterface;

class IncluirNotaEntradaController
{

    private $notaEntradaService;


    public function __construct(IncluirNotaEntradaServiceInterface $notaEntradaService)
    {
        $this->notaEntradaService = $notaEntradaService;
    }

    /**
     * Pega os dados da nota de entrada na action
     * @param $data
     * @return void
     */
    public function getNotaEntrada(array $data) {}
}
