<?php

namespace Andre\GestaoDeEstoque\Actions;

use Andre\GestaoDeEstoque\Controllers\UserController;
use Andre\GestaoDeEstoque\Containers\ServiceContainer;

class CadastrarUsuarioAction implements ActionInterface
{
    private $userController;

    public function __construct(ServiceContainer $container, UserController $userController)
    {
        $container->register('cadastrar-usuario', $this);
        $this->userController = $userController;
    }

    public function execute(array $data)
    {
        return $this->userController->processRequest($data);
    }
}
