<?php

namespace Andre\GestaoDeEstoque\Database;

interface DatabaseInterface
{
    public function connect();

    public function getConnection();
}
