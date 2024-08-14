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

$databaseInterface = new MySQLDatabase();
$databaseManager = new DatabaseManager($databaseInterface);
$userRepository = new UserRepository($databaseManager);
$userService = new UserService($userRepository);
$userController = new UserController($userService);

$container = new ServiceContainer();
new CadastrarUsuarioAction($container, $userController);
new AutenticarUsuarioAction($container, $userController);

$handleRequest = new HandleRequestController($container);
$handleRequest->processRequest();
