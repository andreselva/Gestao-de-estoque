<?php

namespace Andre\GestaoDeEstoque\Parameters;

use Andre\GestaoDeEstoque\Parameters\ParametersRepositoryInterface;

class ParametersRepository implements ParametersRepositoryInterface
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getParameters(): array
    {
        $sql = "SELECT * FROM parameters";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $parameters = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($parameters) {
            return $parameters;
        }
    }

}

