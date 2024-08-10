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

        if (isset($request['email'])) {
            $email = $request['email'];
            $password = $request['password'];
            $username = $request['username'];
        } else {
            $password = $request['password'];
            $username = $request['username'];
        }

        switch ($action) {
            case 'cadastrar-usuario':
                $this->userService->registerUser($email, $password, $username);
                break;
            case 'autenticar-usuario':
                $this->userService->getUserForAuthentication($username, $password);
                break;

            default:
                return;
        }
    }
}
