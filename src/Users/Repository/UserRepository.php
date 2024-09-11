<?php

namespace Andre\GestaoDeEstoque\Users\Repository;

use Andre\GestaoDeEstoque\Users\Entity\User;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user): void
    {
        $sql = "INSERT INTO users (email, password, username) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $user->getEmail());
        $stmt->bindValue(2, $user->getPassword());
        $stmt->bindValue(3, $user->getUsername());
        $stmt->execute();
    }
}
