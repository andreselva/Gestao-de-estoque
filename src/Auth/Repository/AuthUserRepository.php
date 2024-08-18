<?php

namespace Andre\GestaoDeEstoque\Auth\Repository;

use Andre\GestaoDeEstoque\Auth\Repository\AuthUserRepositoryInterface;
use Andre\GestaoDeEstoque\Auth\Entity\Auth;
use Exception;

class AuthUserRepository implements AuthUserRepositoryInterface
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function AuthUser(Auth $authUser)
    {
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $authUser->getUsername());
        $stmt->execute();
    }
}
