<?php

namespace Andre\GestaoDeEstoque\Auth\Services;

use Andre\GestaoDeEstoque\Auth\Entity\Auth;
use Andre\GestaoDeEstoque\Auth\Repository\AuthUserRepositoryInterface;
use Andre\GestaoDeEstoque\Session\Session;
use Andre\GestaoDeEstoque\Validation\DataSanitizer;

class AuthService
{
    private $authUserRepository;
    private $sanitizer;

    public function __construct(AuthUserRepositoryInterface $authUserRepository, DataSanitizer $sanitizer)
    {
        $this->authUserRepository = $authUserRepository;
        $this->sanitizer = $sanitizer;
    }

    public function authenticate($username, $password)
    {
        $cleanedUsername = $this->sanitizer->sanitize($username);
        $cleanedPass = $this->sanitizer->sanitize($password);
        $authUser = new Auth($cleanedUsername, $cleanedPass);
        $userData = $this->authUserRepository->findUserByUsername($authUser->getUsername());

        if (!$userData || !password_verify($authUser->getPassword(), $userData['password'])) {
            return;
        };

        $session = Session::getInstance();
        $session->initSession();
        $session->regenerateCookieSession();
        $session->buildConn($userData);
    }
}
