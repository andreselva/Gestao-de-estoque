<?php

namespace Andre\GestaoDeEstoque\Actions;

use Andre\GestaoDeEstoque\Containers\ServiceContainer;
use Andre\GestaoDeEstoque\NotasFiscais\IncluirNota\Controllers\IncluirNotaEntradaController;

class IncluirNotaEntradaAction implements ActionInterface
{

    private $notaEntradaController;

    public function __construct(ServiceContainer $container, IncluirNotaEntradaController $notaEntradaController)
    {
        $container->register('cadastrar-nota-entrada', $this);
        $this->notaEntradaController = $notaEntradaController;
    }

    public function execute(?array $data)
    {
        $this->notaEntradaController->getNotaEntrada($data);
    }
}
