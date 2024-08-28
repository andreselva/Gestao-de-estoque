<?php

namespace Andre\GestaoDeEstoque\Auth\Controllers;

use Andre\GestaoDeEstoque\Auth\Entity\Auth;
use Andre\GestaoDeEstoque\Auth\Services\AuthService;

class AuthController
{
    private $authService;
    private const ACTION_AUTHENTICATE = 'autenticar-usuario';

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(array $data): void
    {
        $action = $data['action'] ?? null;
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if (!$this->isValidLogin($action, $username, $password)) {
            $this->sendJsonResponse(["status" => "error", "message" => "Falha ao realizar login!"]);
            return;
        }

        $user = new Auth($username, $password);
        $result = $this->authService->authenticate($user);
        $this->sendJsonResponse($result);
    }


    private function isValidLogin(?string $action, ?string $username, ?string $password): ?bool
    {
        return $action === self::ACTION_AUTHENTICATE && !empty($username) && !empty($password);
    }


    private function sendJsonResponse(array $response): void
    {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
