<?php

namespace Andre\GestaoDeEstoque\Auth\Repository;

interface AuthUserRepositoryInterface
{
    public function findUserByUsername(string $username);
}
