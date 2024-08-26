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

    public function authenticate(Auth $authUser): array
    {
        $userData = $this->authUserRepository->findUserByUsername($authUser->getUsername());
        if (!$userData || !password_verify($authUser->getPassword(), $userData['password'])) {
            return ["status" => "error", "message" => "Falha durante a autenticação!"];
        };
        $result = $this->buildConn($userData['id'], $userData['username']);
        return ["status" => "success", "data" => $result];
    }

    private function buildConn($userId, $username): array
    {
        return [
            'connected' => true,
            'userId' => $userId,
            'username' => $username
        ];
    }
}
