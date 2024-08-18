<?php

namespace Andre\GestaoDeEstoque\Auth\Repository;

use Andre\GestaoDeEstoque\Auth\Entity\Auth;

interface AuthUserRepositoryInterface
{
    public function AuthUser(Auth $authUser);
}
