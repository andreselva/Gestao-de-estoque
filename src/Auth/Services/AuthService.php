<?php

namespace Andre\GestaoDeEstoque\Auth\Services;

use Andre\GestaoDeEstoque\Auth\Entity\Auth;
use Andre\GestaoDeEstoque\Auth\Repository\AuthUserRepositoryInterface;
use Andre\GestaoDeEstoque\Auth\Session\Session;

class AuthService
{
    private $authUserRepository;

    public function __construct(AuthUserRepositoryInterface $authUserRepository)
    {
        $this->authUserRepository = $authUserRepository;
    }

    public function authenticate(Auth $authUser): array
    {
        $userData = $this->authUserRepository->findUserByUsername($authUser->getUsername());

        if (!$userData || !password_verify($authUser->getPassword(), $userData['password'])) {
            return ["status" => "error", "message" => "Falha durante a autenticação!"];
        };

        $session = Session::getInstance();
        $session->initSession();
        $session->buildConn($userData);
        return ["status" => "success"];
    }
}
