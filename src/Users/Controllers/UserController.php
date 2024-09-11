<?php

namespace Andre\GestaoDeEstoque\Users\Controllers;

use Andre\GestaoDeEstoque\Users\Services\UserService;
use Exception;
use InvalidArgumentException;

class UserController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUserForRegister(?array $request): void
    {
        $email = $request['email'];
        $password = $request['password'];
        $username = $request['username'];

        try {
            $this->userService->registerUser($email, $password, $username);
            $this->sendJsonResponse(['message' => 'User registered succesfully'], 200);
        } catch (InvalidArgumentException $e) {
            $this->sendJsonResponse(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            $this->sendJsonResponse(['error' => 'An unexpected error ocurred'], 500);
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
