<?php

namespace Andre\GestaoDeEstoque\Auth\Controllers;

use Andre\GestaoDeEstoque\Auth\Entity\Auth;
use Andre\GestaoDeEstoque\Auth\Services\AuthService;

class AuthController
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(array $data): void
    {
        $action = $data['action'];
        $username = $data['username'];
        $password = $data['password'];

        if (isset($action)) {
            if ($action === 'autenticar-usuario') {
                $user = new Auth($username, $password);
                $result = $this->authService->authenticate($user);
                header('Content-Type: application/json');
                echo json_encode($result);
                exit;
            }
        }
    }
}
