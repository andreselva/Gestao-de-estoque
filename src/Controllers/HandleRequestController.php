<?php

namespace Andre\GestaoDeEstoque\Controllers\HandleRequestController;
require_once __DIR__ . '/../../vendor/autoload.php';

use Andre\GestaoDeEstoque\Controllers\UserController;
use Andre\GestaoDeEstoque\Database\DatabaseManager;
use Andre\GestaoDeEstoque\Services\UserService;
use Andre\GestaoDeEstoque\Database\MySQLDatabase;
use Andre\GestaoDeEstoque\Repository\UserRepository;

$databaseInterface = new MySQLDatabase();
$databaseManager = new DatabaseManager($databaseInterface);
$userRepository = new UserRepository($databaseManager);
$userService = new UserService($userRepository);
$userController = new UserController($userService);
$handleRequest = new HandleRequest($userController);
$handleRequest->processRequest();

class HandleRequest
{
    private $userController;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }

    public function processRequest()
    {

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            header('Content-Type: application/json');
            $json_data = file_get_contents("php://input");
            error_log("Recebido: " . $json_data);
            $data = json_decode($json_data, true);

            if (isset($data['action'])) {
                $action = $data['action'];

                switch ($action) {
                    case 'cadastrar-usuario':
                        return $this->userController->processRequest($data);
                    default:
                        // Resposta para ações não reconhecidas
                        http_response_code(400);
                        echo json_encode(['error' => 'Ação inválida.']);
                        break;
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Ação não especificada.']);
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Método HTTP não suportado.']);
        }
    }

    
}
