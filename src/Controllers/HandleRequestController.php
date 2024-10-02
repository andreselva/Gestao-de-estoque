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
        if (isset($_GET['action'])) {
            $action = $_GET['action'];

            switch ($action) {
                case 'buscar-produto':
                case 'buscar-lancamentos':
                    $idProduto = $_GET['id'] ?? null;
                    if ($idProduto) {
                        $data['idProduto'] = $idProduto;
                    } else {
                        $this->sendError('ID do produto não fornecido.');
                    }
                    break;
                case 'dropdown-produtos':
                    $searched = $_GET['search'] ?? null;
                    if ($searched) {
                        $data['searched'] = $searched;
                    } else {
                        $this->sendError('Nenhum valor fornecido para busca.');
                    }
                    break;
                case 'listar-produtos':
                    if (isset($_GET['situation']) && $_GET['situation'] !== null && $_GET['situation'] !== '') {
                        $situation = explode(', ', $_GET['situation']); // Divide a string em um array
                        $data['situation'] = $situation; // Atribui o array à variável de dados
                    }

                    if (isset($_GET['dataCriacao']) && $_GET['dataCriacao'] !== null && $_GET['dataCriacao'] !== '') {
                        $dataCreate[] = $_GET['dataCriacao'];
                        $data['dateCreate'] = $dataCreate;
                    }
                    break;
                default:
                    $this->sendError('Nenhuma ação válida.');
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
