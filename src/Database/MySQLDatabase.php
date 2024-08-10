<?php

namespace Andre\GestaoDeEstoque\Database;

use Andre\GestaoDeEstoque\Database\DatabaseInterface;
use Andre\GestaoDeEstoque\Database\DatabaseConfig;
use PDO;

class MySQLDatabase implements DatabaseInterface
{
    private $connection;

    public function connect()
    {
        $config = DatabaseConfig::getMySQLConfig();
        $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'];
        $this->connection = new PDO($dsn, $config['username'], $config['password']);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
