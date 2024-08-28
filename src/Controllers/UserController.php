<?php

namespace Andre\GestaoDeEstoque\Controllers;

use Andre\GestaoDeEstoque\Services\UserService;

class UserController
{
    private $userService;
    private const CADASTRAR_USUARIO = 'cadastrar-usuario';

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function processRequest(?array $request): void
    {
        $action = $request['action'];
        $email = $request['email'];
        $password = $request['password'];
        $username = $request['username'];

        if (!$this->isValidRequest($action, $email, $password, $username)) {
            $this->sendJsonResponse(["status" => "error", "message" => "Falha ao realizar cadastro!"]);
            return;
        }

        switch ($action) {
            case 'cadastrar-usuario':
                $values = [$email, $password, $username];
                if (in_array("", array_map('trim', $values))) {
                    $this->sendHttpResponse(400);
                    $this->sendJsonResponse(["status" => "error", "message" => "Campos vazios. Verifique!"]);
                    return;
                }
                $this->userService->registerUser($email, $password, $username);
                break;
            default:
                $this->sendHttpResponse(405);
        }

    }

    private function isValidRequest($action, $email, $password, $username): ?bool
    {
        return $action === self::CADASTRAR_USUARIO && !empty($email) && !empty($password) && !empty($username);
    }

    private function sendHttpResponse(?int $code): void
    {
        http_response_code($code);
    }

    private function sendJsonResponse(?array $response): void
    {
        echo json_encode($response);
    }
}
