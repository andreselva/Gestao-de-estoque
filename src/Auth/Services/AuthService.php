<?php

namespace Andre\GestaoDeEstoque\Auth\Services;

use Andre\GestaoDeEstoque\Auth\Repository\AuthUserRepository;
use Andre\GestaoDeEstoque\Auth\Entity\Auth;


class AuthService
{
    private $authUserRepository;

    public function __construct(AuthUserRepository $authUserRepository)
    {
        $this->authUserRepository = $authUserRepository;
    }

    public function AuthUser($username, $password)
    {
        $authUser = new Auth($username, $password);
        $this->authUserRepository->AuthUser($authUser);
    }
}
