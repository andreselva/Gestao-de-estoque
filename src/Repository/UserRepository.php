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

    public function authenticateUser(User $user)
    {
        try {
            $sql = "SELECT * FROM users WHERE username=?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $user->getUsername());
            $stmt->execute();

            $userData = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (empty($userData)) {
                http_response_code(401);
                echo json_encode(["status" => "Verifique os dados informados!"]);
                return;
            }

            $passwordVerified = password_verify($user->getPassword(), $userData['password']);

            if (!$passwordVerified) {
                http_response_code(401);
                echo json_encode(["status" => "Verifique os dados informados!"]);
                return;
            } else {
                $_SERVER['logado'] = true;
                echo json_encode(["status" => "sucess"]);
                header('Location: /index.php');
                exit();
            }
        } catch (Exception $e) {
            http_response_code(405);
            $msg = $e->getMessage();
            echo json_encode(["status" => "error"]);
        }
    }
}
