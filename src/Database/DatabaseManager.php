<?php

namespace Andre\GestaoDeEstoque\Database;

use Andre\GestaoDeEstoque\Database\DatabaseInterface;

class DatabaseManager
{
    private $connection;

    public function __construct(DatabaseInterface $databaseInterface)
    {
        $databaseInterface->connect();
        $this->connection = $databaseInterface->getConnection();
    }
    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
