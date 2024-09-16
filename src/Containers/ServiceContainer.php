<?php

namespace Andre\GestaoDeEstoque\Containers;

use Andre\GestaoDeEstoque\Auth\Repository\AuthUserRepository;

class ServiceContainer
{
    private $services = [];

    public function __construct()
    {
        $this->services['MySQLDatabase'] = function () {
            return new \Andre\GestaoDeEstoque\Database\MySQLDatabase();
        };

        $this->services['DatabaseManager'] = function () {
            return new \Andre\GestaoDeEstoque\Database\DatabaseManager($this->get('MySQLDatabase'));
        };
        
        $this->services['DataSanitizer'] = function () {
            return new \Andre\GestaoDeEstoque\Validation\DataSanitizer();
        };

        $this->services['PasswordHasher'] = function () {
            return new \Andre\GestaoDeEstoque\Users\Security\PasswordHasher();
        };

        $this->services['AuthController'] = function () {
            return new \Andre\GestaoDeEstoque\Auth\Controllers\AuthController($this->get('AuthService'));
        };

        $this->services['AuthService'] = function () {
            return new \Andre\GestaoDeEstoque\Auth\Services\AuthService($this->get('AuthUserRepository'), $this->get('DataSanitizer'));
        };

        $this->services['AuthUserRepository'] = function () {
            return new \Andre\GestaoDeEstoque\Auth\Repository\AuthUserRepository($this->get('DatabaseManager'));
        };

        $this->services['autenticar-usuario'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\AutenticarUsuarioAction($this, $this->get('AuthController'));
        };

        $this->services['cadastrar-usuario'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\CadastrarUsuarioAction($this, $this->get('UserController'));
        };

        $this->services['UserController'] = function () {
            return new \Andre\GestaoDeEstoque\Users\Controllers\UserController($this->get('UserService'));
        };

        $this->services['UserService'] = function () {
            return new \Andre\GestaoDeEstoque\Users\Services\UserService(
                $this->get('UserRepository'),
                $this->get('DataSanitizer'),
                $this->get('PasswordHasher')
            ,);
        };

        $this->services['UserRepository'] = function () {
            return new \Andre\GestaoDeEstoque\Users\Repository\UserRepository($this->get('DatabaseManager'));   
        };

        $this->services['cadastrar-produto'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\CadastrarProdutosAction($this, $this->get('ProductsController'));
        };

        $this->services['listar-produtos'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\ListarProdutosAction($this, $this->get('ProductsController'));
        };

        $this->services['buscar-produto'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\BuscarProdutoAction($this, $this->get('ProductsController'));
        };

        $this->services['editar-produto'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\EditarProdutoAction($this, $this->get('ProductsController'));
        };

        $this->services['ProductsController'] = function () {
            return new \Andre\GestaoDeEstoque\Produtos\Controllers\ProductsController($this->get('ProductService'));
        };

        $this->services['ProductService'] = function () {
            return new \Andre\GestaoDeEstoque\Produtos\Services\ProductService(
                $this->get('ProductRepository'), 
                $this->get('DataSanitizer')
            );
        };

        $this->services['ProductRepository'] = function () {
            return new \Andre\GestaoDeEstoque\Produtos\Repository\ProductRepository($this->get('DatabaseManager'));
        };
    }

      public function register($name, $callback)
    {
        $this->services[$name] = $callback;
    }


    public function get($serviceName)
    {
        if (isset($this->services[$serviceName])) {
            return $this->services[$serviceName]();
        }

        throw new \Exception("Serviço não encontrado: $serviceName");
    }
}
