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
        if (!in_array($_SERVER['REQUEST_METHOD'], ['POST', 'GET'])) {
            http_response_code(405);
            return $this->sendError('Método HTTP não suportado.');
        }

        $data = $this->getRequestData();
        $actionName = $data['action'] ?? $_GET['action'] ?? null;

        if ($actionName) {
            try {
                $action = $this->serviceContainer->get($actionName);
                return $action->execute($data);
            } catch (\Exception $e) {
                http_response_code(500);
                return $this->sendError('Erro ao processar ação: ' . $e->getMessage());
            }
        }

        http_response_code(400);
        return $this->sendError('Ação inválida.');
    }

    private function getRequestData(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return json_decode(file_get_contents("php://input"), true) ?? [];
        }

        $data = [];
        if (isset($_GET['action']) && $_GET['action'] === 'buscar-produto') {
            $idProduto = $_GET['id'] ?? null;
            if ($idProduto) {
                $data['idProduto'] = $idProduto;
            } else {
                $this->sendError('ID do produto não fornecido.');
            }
        }

        return $data;
    }

    private function sendError(string $message)
    {
        echo json_encode(['error' => $message]);
        exit;
    }
}
