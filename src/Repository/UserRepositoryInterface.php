<?php

namespace Andre\GestaoDeEstoque\Repository;

use Andre\GestaoDeEstoque\Entity\User;

interface UserRepositoryInterface {
    public function save(User $user);
}
