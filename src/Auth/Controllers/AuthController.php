<?php

namespace Andre\GestaoDeEstoque\Auth\Controllers;
use Andre\GestaoDeEstoque\Auth\Services\AuthService;

class AuthController
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function getDataForAuth(array $data)
    {
        $action = $data['action'];
        $username = $data['username'];
        $password = $data['password'];

        if (isset($action)) {
            if ($action === 'autenticar-usuario') {
                $this->authService->AuthUser($username, $password);
            }
        }
    }
}
