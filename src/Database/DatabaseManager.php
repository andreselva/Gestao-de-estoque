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

    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    public function commit()
    {
        return $this->connection->commit();
    }

    public function rollback()
    {
        return $this->connection->rollback();
    }
}
