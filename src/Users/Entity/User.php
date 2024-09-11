<?php

namespace Andre\GestaoDeEstoque\Users\Entity;

class User
{
    private $email;
    private $password;
    private $username;

    public function __construct($username, $password, $email = '')
    {
        if (empty($username) || empty($password) || empty($email)) {
            throw new \InvalidArgumentException('Username, password or email cannot be empty');
        }
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
