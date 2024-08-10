<?php

namespace Andre\GestaoDeEstoque\Database;

class DatabaseConfig
{

    public static function getMySQLConfig()
    {
        return [
            'host' => 'localhost',
            'dbname' => 'dbsystem',
            'username' => 'root',
            'password' => '123456'
        ];
    }
}
