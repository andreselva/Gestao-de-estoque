<?php

namespace Andre\GestaoDeEstoque\Users\Entity;

class User
{
    private $email;
    private $password;
    private $username;

    public function __construct($username, $password, $email = '')
    {
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
