<?php

namespace Andre\GestaoDeEstoque\Controllers;

use Andre\GestaoDeEstoque\Containers\ServiceContainer;

class HandleRequestController
{
    private $serviceContainer;

    public function __construct(ServiceContainer $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    public function processRequest()
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST' || $_SERVER["REQUEST_METHOD"] === 'GET') {
            $json_data = file_get_contents("php://input");
            $data = json_decode($json_data, true) ?? null;

            if (isset($data['action'])) {
                $action = $this->serviceContainer->get($data['action']);
            } else if (isset($_GET['action'])) {
                $action = $this->serviceContainer->get($_GET['action']);
            }

            if ($action) {
                return $action->execute($data);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Ação inválida.']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método HTTP não suportado.']);
        }
    }
}
