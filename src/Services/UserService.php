<?php

namespace Andre\GestaoDeEstoque\Services;

use Andre\GestaoDeEstoque\Database\DatabaseManager;
use Exception;

class UserService
{
    private $connection;

    public function __construct(DatabaseManager $connection)
    {
        $this->connection = $connection->getDatabaseConnection();
    }

    public function registerUser($email, $password, $username)
    {
        try {
            $cleanedEmail = preg_replace('/[^a-zA-Z0-9._@-]/', '', $email);
            $cleanedUsername = preg_replace('/[^a-zA-z0-9._@-]/', '', $username);
            $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

            $sql = "INSERT INTO users (email, password, username) VALUES (?, ?, ?)";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $cleanedEmail);
            $stmt->bindValue(2, $hashedPassword);
            $stmt->bindValue(3, $cleanedUsername);
            $res = $stmt->execute();

            if ($res) {
                echo json_encode(["status" => "success", "message" => "Cadastro bem sucedido"]);
            }
        } catch (Exception $e) {
            $msg = $e->getMessage();
            echo json_encode(["status" => "error", "message" => $msg]);
        }
    }
}
