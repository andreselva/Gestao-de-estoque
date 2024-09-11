<?php

namespace Andre\GestaoDeEstoque\Users\Services;

use Andre\GestaoDeEstoque\Users\Repository\UserRepositoryInterface;
use Andre\GestaoDeEstoque\Users\Entity\User;
use Andre\GestaoDeEstoque\Users\Security\PasswordHasher;
use Andre\GestaoDeEstoque\Validation\DataSanitizer;

class UserService
{
    private $userRepository;
    private $sanitizer;
    private $hasher;

    public function __construct(UserRepositoryInterface $userRepository, DataSanitizer $sanitizer, PasswordHasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->sanitizer = $sanitizer;
        $this->hasher = $hasher;
    }

    public function registerUser($email, $password, $username)
    {
        $cleanedUsername = $this->sanitizer->sanitize($username);
        $cleanedEmail = $this->sanitizer->sanitize($email);
        $hashedPassword = $this->hasher->VerifyAndHashPass($password);

        $user = new User($cleanedUsername, $hashedPassword, $cleanedEmail);
        $this->userRepository->save($user);
    }
}
