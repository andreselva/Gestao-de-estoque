<?php

namespace Andre\GestaoDeEstoque\Users\Security;

class PasswordHasher
{
    public function __construct() {}

    /**
     * Verifica e realiza o hash de senha
     * 
     * @param string $password
     * @return string
     */
    public function VerifyAndHashPass($password)
    {
        if (empty($password)) {
            throw new \InvalidArgumentException('Password cannot be empty');
        }
        return password_hash($password, PASSWORD_ARGON2ID);
    }
}
