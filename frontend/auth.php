<?php
require_once __DIR__ . '../../vendor/autoload.php';

use Andre\GestaoDeEstoque\Auth\Session\Session;

$session = Session::getInstance();
$session->initSession();
$session->checkAuthentication();
