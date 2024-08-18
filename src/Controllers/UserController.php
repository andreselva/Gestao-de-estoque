<?php

namespace Andre\GestaoDeEstoque\Controllers;

use Andre\GestaoDeEstoque\Services\UserService;

class UserController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function processRequest(array $request)
    {
        $action = $request['action'];
        $email = $request['email'];
        $password = $request['password'];
        $username = $request['username'];


        switch ($action) {
            case 'cadastrar-usuario':
                $values = [$email, $password, $username];
                if (in_array("", array_map('trim', $values))) {
                    http_response_code(400);
                    echo json_encode(["status" => "error", "message" => "Campos vazios. Verifique!"]);
                    return;
                }
                $this->userService->registerUser($email, $password, $username);
                break;
            default:
                http_response_code(405);
        }
    }
}
