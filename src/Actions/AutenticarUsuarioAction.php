<?php

namespace Andre\GestaoDeEstoque\Actions;

use Andre\GestaoDeEstoque\Auth\Controllers\AuthController;
use Andre\GestaoDeEstoque\Containers\ServiceContainer;

class AutenticarUsuarioAction implements ActionInterface
{
    private $authController;

    public function __construct(ServiceContainer $container, AuthController $authController)
    {
        $container->register('autenticar-usuario', $this);
        $this->authController = $authController;
    }

    public function execute(array $data)
    {
        return $this->authController->getDataForAuth($data);
    }
}
