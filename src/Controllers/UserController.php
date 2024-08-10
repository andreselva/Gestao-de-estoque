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
                $this->userService->registerUser($email, $password, $username);
                break;
            default:
                return;
        }
    }
}
