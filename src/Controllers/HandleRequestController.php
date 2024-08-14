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
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $json_data = file_get_contents("php://input");
            $data = json_decode($json_data, true);

            if (isset($data['action'])) {
                $action = $this->serviceContainer->get($data['action']);

                if ($action) {
                    return $action->execute($data);
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Ação inválida.']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Ação não especificada.']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método HTTP não suportado.']);
        }
    }
}
