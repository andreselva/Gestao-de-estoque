<?php

namespace Andre\GestaoDeEstoque\Auth\Controllers;

use Andre\GestaoDeEstoque\Auth\Entity\Auth;
use Andre\GestaoDeEstoque\Auth\Services\AuthService;
use Exception;
use InvalidArgumentException;

class AuthController
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(array $data): void
    {
        $username = $data['username'];
        $password = $data['password'];

        try {
            $this->authService->authenticate($username, $password);
            $this->sendJsonResponse(['status' => 'success'], 200);
        } catch (InvalidArgumentException $e) {
            $this->sendJsonResponse(['status' => 'error', 'error-msg' => $e->getMessage()], 400);
        } catch (Exception $e) {
            $this->sendJsonResponse(['status' => 'error'], 500);
        }
    }


    private function sendJsonResponse(array $response, int $code): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
