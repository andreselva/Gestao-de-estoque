<?php

namespace Andre\GestaoDeEstoque\Database;

use Andre\GestaoDeEstoque\Database\DatabaseInterface;

class DatabaseManager
{
    private $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
        $this->database->connect();
    }

    public function getDatabaseConnection()
    {
        return $this->database->getConnection();
    }
}
