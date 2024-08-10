<?php

namespace Andre\GestaoDeEstoque\Repository;

use Andre\GestaoDeEstoque\Entity\User;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user)
    {
        try {
            $sql = "INSERT INTO users (email, password, username) VALUES (?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $user->getEmail());
            $stmt->bindValue(2, $user->getPassword());
            $stmt->bindValue(3, $user->getUsername());
            $res = $stmt->execute();

            if ($res) {
                echo json_encode(["status" => "sucess", "message" => "Cadastro realizado!"]);
            }
            
        } catch (Exception $e) {
            http_response_code(400);
            $msg = $e->getMessage();
            echo json_encode(["status" => "error", "message" => $msg]);
        }
    }
}
