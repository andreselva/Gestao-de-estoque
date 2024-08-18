<?php

namespace Andre\GestaoDeEstoque\Services;

use Andre\GestaoDeEstoque\Repository\UserRepositoryInterface;
use Andre\GestaoDeEstoque\Entity\User;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser($email, $password, $username)
    {
        $cleanedEmail = preg_replace('/[^a-zA-Z0-9._@-]/', '', $email);
        $cleanedUsername = preg_replace('/[^a-zA-z0-9._@-]/', '', $username);
        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

        $user = new User($cleanedUsername, $hashedPassword, $cleanedEmail);
        $this->userRepository->save($user);
    }
 
}
