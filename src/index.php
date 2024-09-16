<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Andre\GestaoDeEstoque\Containers\ServiceContainer;
use Andre\GestaoDeEstoque\Database\MySQLDatabase;
use Andre\GestaoDeEstoque\Database\DatabaseManager;
use Andre\GestaoDeEstoque\Controllers\HandleRequestController;
use Andre\GestaoDeEstoque\Actions\CadastrarUsuarioAction;
use Andre\GestaoDeEstoque\Actions\AutenticarUsuarioAction;
use Andre\GestaoDeEstoque\Actions\BuscarProdutoAction;
use Andre\GestaoDeEstoque\Actions\CadastrarProdutosAction;
use Andre\GestaoDeEstoque\Actions\EditarProdutoAction;
use Andre\GestaoDeEstoque\Actions\LancarEstoqueAction;
use Andre\GestaoDeEstoque\Actions\ListarProdutosAction;
use Andre\GestaoDeEstoque\Users\Controllers\UserController;
use Andre\GestaoDeEstoque\Users\Repository\UserRepository;
use Andre\GestaoDeEstoque\Users\Services\UserService;
use Andre\GestaoDeEstoque\Auth\Controllers\AuthController;
use Andre\GestaoDeEstoque\Auth\Repository\AuthUserRepository;
use Andre\GestaoDeEstoque\Auth\Services\AuthService;
use Andre\GestaoDeEstoque\Produtos\Controllers\ProductsController;
use Andre\GestaoDeEstoque\Produtos\Repository\ProductRepository;
use Andre\GestaoDeEstoque\Produtos\Services\ProductService;
use Andre\GestaoDeEstoque\Stock\Controllers\StockController;
use Andre\GestaoDeEstoque\Stock\Repository\StockRepository;
use Andre\GestaoDeEstoque\Stock\Services\StockService;
use Andre\GestaoDeEstoque\Validation\DataSanitizer;
use Andre\GestaoDeEstoque\Users\Security\PasswordHasher;

//COMPONENTES
$dataSanitizer = new DataSanitizer();

//INICIA CONEXAO BANCO
$databaseInterface = new MySQLDatabase();
$databaseManager = new DatabaseManager($databaseInterface);

//PARA USUARIOS
$securityPass = new PasswordHasher();
$userRepository = new UserRepository($databaseManager);
$userService = new UserService($userRepository, $dataSanitizer, $securityPass);
$userController = new UserController($userService);

//PARA AUTENTICAÇÃO
$authUserRepository = new AuthUserRepository($databaseManager);
$authService = new AuthService($authUserRepository, $dataSanitizer);
$authController = new AuthController($authService);

//PARA CADASTRAR PRODUTOS
$productRepository = new ProductRepository($databaseManager);
$productService = new ProductService($productRepository, $dataSanitizer);
$productController = new ProductsController($productService);

//PARA LANCAMENTO DE ESTOQUE
$stockRepository = new StockRepository($databaseManager);
$stockService = new StockService($stockRepository);
$stockController = new StockController($stockService);


$container = new ServiceContainer();
new CadastrarUsuarioAction($container, $userController);
new AutenticarUsuarioAction($container, $authController);
new CadastrarProdutosAction($container, $productController);
new ListarProdutosAction($container, $productController);
new BuscarProdutoAction($container, $productController);
new EditarProdutoAction($container, $productController);
new LancarEstoqueAction($container, $stockController);

$handleRequest = new HandleRequestController($container);
$handleRequest->processRequest();
