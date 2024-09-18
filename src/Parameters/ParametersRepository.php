<?php

namespace Andre\GestaoDeEstoque\Parameters;

use Andre\GestaoDeEstoque\Parameters\ParametersRepositoryInterface;

class ParametersRepository implements ParametersRepositoryInterface
{
    private $connection;
    public const CALCULA_CUSTO = '';

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    private function getParameters()
    {
        $sql = "SELECT * FROM parameters";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $parameters = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($parameters) {
            return $parameters;
        }
    }

    public function getValueParam($nameParam): int
    {
        $parameters = $this->getParameters();
        $value = 0;

        foreach ($parameters as $param) {
            if ($param['parametro'] === $nameParam) {
                $value = $param['valor'];
            }
        }

        return $value;
    }
}
