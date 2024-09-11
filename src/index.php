<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Andre\GestaoDeEstoque\Containers\ServiceContainer;
use Andre\GestaoDeEstoque\Database\MySQLDatabase;
use Andre\GestaoDeEstoque\Database\DatabaseManager;
use Andre\GestaoDeEstoque\Controllers\HandleRequestController;
use Andre\GestaoDeEstoque\Actions\CadastrarUsuarioAction;
use Andre\GestaoDeEstoque\Actions\AutenticarUsuarioAction;
use Andre\GestaoDeEstoque\Users\Controllers\UserController;
use Andre\GestaoDeEstoque\Users\Repository\UserRepository;
use Andre\GestaoDeEstoque\Users\Services\UserService;
use Andre\GestaoDeEstoque\Auth\Controllers\AuthController;
use Andre\GestaoDeEstoque\Auth\Repository\AuthUserRepository;
use Andre\GestaoDeEstoque\Auth\Services\AuthService;
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


$container = new ServiceContainer();
new CadastrarUsuarioAction($container, $userController);
new AutenticarUsuarioAction($container, $authController);

$handleRequest = new HandleRequestController($container);
$handleRequest->processRequest();
