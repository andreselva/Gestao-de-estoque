<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Andre\GestaoDeEstoque\Containers\ServiceContainer;
use Andre\GestaoDeEstoque\Controllers\UserController;
use Andre\GestaoDeEstoque\Database\MySQLDatabase;
use Andre\GestaoDeEstoque\Database\DatabaseManager;
use Andre\GestaoDeEstoque\Repository\UserRepository;
use Andre\GestaoDeEstoque\Services\UserService;
use Andre\GestaoDeEstoque\Controllers\HandleRequestController;
use Andre\GestaoDeEstoque\Actions\CadastrarUsuarioAction;
use Andre\GestaoDeEstoque\Actions\AutenticarUsuarioAction;
use Andre\GestaoDeEstoque\Auth\Controllers\AuthController;
use Andre\GestaoDeEstoque\Auth\Repository\AuthUserRepository;
use Andre\GestaoDeEstoque\Auth\Services\AuthService;


$databaseInterface = new MySQLDatabase();
$databaseManager = new DatabaseManager($databaseInterface);
$userRepository = new UserRepository($databaseManager);
$userService = new UserService($userRepository);
$userController = new UserController($userService);


//PARA AUTENTICAÇÃO
$authUserRepository = new AuthUserRepository($databaseManager);
$authService = new AuthService($authUserRepository);
$authController = new AuthController($authService);


$container = new ServiceContainer();
new CadastrarUsuarioAction($container, $userController);
new AutenticarUsuarioAction($container, $authController);

$handleRequest = new HandleRequestController($container);
$handleRequest->processRequest();