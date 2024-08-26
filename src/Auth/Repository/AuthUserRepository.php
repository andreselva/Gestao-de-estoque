<?php

namespace Andre\GestaoDeEstoque\Auth\Repository;

use Andre\GestaoDeEstoque\Auth\Repository\AuthUserRepositoryInterface;
use Andre\GestaoDeEstoque\Auth\Entity\Auth;
use PDOException;
use PDO;

class AuthUserRepository implements AuthUserRepositoryInterface
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function findUserByUsername(string $username): ?array
    {
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
