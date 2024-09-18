<?php

namespace Andre\GestaoDeEstoque\Stock\Controllers;

use Andre\GestaoDeEstoque\Stock\Services\StockServiceInterface;
use Exception;
use InvalidArgumentException;

class StockController
{

    private $stockService;

    public function __construct(StockServiceInterface $stockService)
    {
        $this->stockService = $stockService;
    }

    public function getStockMovement(array $data) {
        try {
            $this->stockService->processStockMovement($data);
            $this->sendJsonResponse(['status' => 'success'], 200);
        } catch (InvalidArgumentException $e) {
            $this->sendJsonResponse(['status' => 'error', 'errorMsg' => $e->getMessage()], 400);
        } catch (Exception $e) {
            $this->sendJsonResponse(['status' => 'error', 'erroMsg' => $e->getMessage()], 500);
        }
    }

    private function sendJsonResponse(array $response, int $code): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
