<?php
// Configurator.php
namespace Andre\GestaoDeEstoque;

class Configurator
{
    public static function setupServiceContainer()
    {
        return new \Andre\GestaoDeEstoque\Containers\ServiceContainer();
    }
}
