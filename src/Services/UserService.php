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
        $values = [$email, $password, $username];

        if (in_array("", array_map('trim', $values))) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Campos vazios. Verifique!"]);
            return;
        }

        $cleanedEmail = preg_replace('/[^a-zA-Z0-9._@-]/', '', $email);
        $cleanedUsername = preg_replace('/[^a-zA-z0-9._@-]/', '', $username);
        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

        $user = new User($cleanedEmail, $hashedPassword, $cleanedUsername);
        $this->userRepository->save($user);
    }

    public function getUserForAuthentication($username, $password)
    {
        $values = [$username, $password];

        if (in_array("", array_map('trim', $values))) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Valores vazios!"]);
            return;
        }

        $cleanedUsername = preg_replace('/[^a-zA-Z0-9._@-]/', '', $username);
        $cleanedPassword = preg_replace('/[^a-zA-Z0-9._@-]/', '', $password);

        $user = new User( $cleanedUsername, $cleanedPassword);
        $this->userRepository->authenticateUser($user);
    }
}
