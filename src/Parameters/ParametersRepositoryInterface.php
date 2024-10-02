<?php

namespace Andre\GestaoDeEstoque\Parameters;

interface ParametersRepositoryInterface
{
    public function getValueParam(string $nameParam): int;
}
