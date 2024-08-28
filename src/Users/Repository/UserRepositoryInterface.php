<?php

namespace Andre\GestaoDeEstoque\Users\Repository;

use Andre\GestaoDeEstoque\Users\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user);
}
