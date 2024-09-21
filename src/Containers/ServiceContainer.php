<?php

namespace Andre\GestaoDeEstoque\Containers;

class ServiceContainer
{
    private $services = [];

    public function __construct()
    {
        $this->services['MySQLDatabase'] = function () {
            return new \Andre\GestaoDeEstoque\Database\MySQLDatabase();
        };

        $this->services['DatabaseManager'] = function () {
            return new \Andre\GestaoDeEstoque\Database\DatabaseManager(
                $this->get('MySQLDatabase')
            );
        };

        $this->services['DataSanitizer'] = function () {
            return new \Andre\GestaoDeEstoque\Validation\DataSanitizer();
        };

        $this->services['PasswordHasher'] = function () {
            return new \Andre\GestaoDeEstoque\Users\Security\PasswordHasher();
        };

        $this->services['ParamatersRepository'] = function () {
            return new \Andre\GestaoDeEstoque\Parameters\ParametersRepository($this->get('DatabaseManager'));
        };

        $this->services['AuthController'] = function () {
            return new \Andre\GestaoDeEstoque\Auth\Controllers\AuthController(
                $this->get('AuthService')
            );
        };

        $this->services['AuthService'] = function () {
            return new \Andre\GestaoDeEstoque\Auth\Services\AuthService(
                $this->get('AuthUserRepository'),
                $this->get('DataSanitizer')
            );
        };

        $this->services['AuthUserRepository'] = function () {
            return new \Andre\GestaoDeEstoque\Auth\Repository\AuthUserRepository(
                $this->get('DatabaseManager')
            );
        };

        $this->services['autenticar-usuario'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\AutenticarUsuarioAction(
                $this,
                $this->get('AuthController')
            );
        };

        $this->services['cadastrar-usuario'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\CadastrarUsuarioAction(
                $this,
                $this->get('UserController')
            );
        };

        $this->services['UserController'] = function () {
            return new \Andre\GestaoDeEstoque\Users\Controllers\UserController(
                $this->get('UserService')
            );
        };

        $this->services['UserService'] = function () {
            return new \Andre\GestaoDeEstoque\Users\Services\UserService(
                $this->get('UserRepository'),
                $this->get('DataSanitizer'),
                $this->get('PasswordHasher'),
            );
        };

        $this->services['UserRepository'] = function () {
            return new \Andre\GestaoDeEstoque\Users\Repository\UserRepository(
                $this->get('DatabaseManager')
            );
        };

        $this->services['cadastrar-produto'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\CadastrarProdutosAction(
                $this,
                $this->get('ProductsController')
            );
        };

        $this->services['listar-produtos'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\ListarProdutosAction(
                $this,
                $this->get('ProductsController')
            );
        };

        $this->services['buscar-produto'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\BuscarProdutoAction(
                $this,
                $this->get('ProductsController')
            );
        };

        $this->services['editar-produto'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\EditarProdutoAction(
                $this,
                $this->get('ProductsController')
            );
        };

        $this->services['dropdown-produtos'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\ListProductsFromDropdownStock(
                $this,
                $this->get('ProductsController')
            );
        };

        $this->services['ProductsController'] = function () {
            return new \Andre\GestaoDeEstoque\Produtos\Controllers\ProductsController(
                $this->get('ProductService')
            );
        };

        $this->services['ProductService'] = function () {
            return new \Andre\GestaoDeEstoque\Produtos\Services\ProductService(
                $this->get('ProductRepository'),
                $this->get('DataSanitizer')
            );
        };

        $this->services['ProductRepository'] = function () {
            return new \Andre\GestaoDeEstoque\Produtos\Repository\ProductRepository(
                $this->get('DatabaseManager')
            );
        };

        $this->services['lancar-estoque'] = function () {
            return new \Andre\GestaoDeEstoque\Actions\LancarEstoqueAction(
                $this,
                $this->get('StockController')
            );
        };

        $this->services['StockController'] = function () {
            return new \Andre\GestaoDeEstoque\Stock\Controllers\StockController(
                $this->get('StockSanitizer')
            );
        };

        $this->services['StockSanitizer'] = function () {
            return new \Andre\GestaoDeEstoque\Stock\Validation\StockSanitizer(
                $this->get('StockValidator')
            );
        };

        $this->services['StockValidator'] = function () {
            return new \Andre\GestaoDeEstoque\Stock\Validation\StockValidator(
                $this->get('StockService')
            );
        };

        $this->services['StockService'] = function () {
            return new \Andre\GestaoDeEstoque\Stock\Services\StockService(
                $this->get('ParametersRepository'),
                $this->get('StockTransactionManager'),
                $this->get('StockMovementProcessor'),
                $this->get('StockUpdater'),
                $this->get('CostUpdater')
            );
        };

        $this->services['StockTransactionManager'] = function () {
            return new \Andre\GestaoDeEstoque\Stock\Manager\StockTransactionManager(
                $this->get('StockRepository')
            );
        };

        $this->services['StockMovementProcessor'] = function () {
            return new \Andre\GestaoDeEstoque\Stock\Processor\StockMovementProcessor($this->get('CostCalculator'));
        };

        $this->services['StockUpdater'] = function () {
            return new \Andre\GestaoDeEstoque\Stock\Updater\StockUpdater($this->get('StockRepository'));
        };

        $this->services['CostUpdater'] = function () {
            return new \Andre\GestaoDeEstoque\Stock\CostCalculator\CostUpdater(
                $this->get('StockRepository'),
                $this->get('CostCalculator')
            );
        };

        $this->services['CostCalculator'] = function () {
            return new \Andre\GestaoDeEstoque\Stock\CostCalculator\CostCalculator();
        };

        $this->services['ParametersRepository'] = function () {
            return new \Andre\GestaoDeEstoque\Parameters\ParametersRepository(
                $this->get('DatabaseManager')
            );
        };

        $this->services['StockRepository'] = function () {
            return new \Andre\GestaoDeEstoque\Stock\Repository\StockRepository(
                $this->get('DatabaseManager')
            );
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
