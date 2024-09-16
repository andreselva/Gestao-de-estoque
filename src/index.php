<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Andre\GestaoDeEstoque\Configurator;

$container = Configurator::setupServiceContainer();
$handleRequest = new \Andre\GestaoDeEstoque\Controllers\HandleRequestController($container);
$handleRequest->processRequest();