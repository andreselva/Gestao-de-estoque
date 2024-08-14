<?php

namespace Andre\GestaoDeEstoque\Containers;

class ServiceContainer
{
    private $services = [];

    public function register($key, $service)
    {
        $this->services[$key] = $service;
    }

    public function get($key)
    {
        return $this->services[$key] ?? null;
    }
}
