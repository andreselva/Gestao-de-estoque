<?php

namespace Andre\GestaoDeEstoque\Stock\Controllers;

use Andre\GestaoDeEstoque\Stock\Validation\StockSanitizer;
use Exception;
use InvalidArgumentException;

class StockController
{

    private $dataSanitizer;

    public function __construct(StockSanitizer $dataSanitizer)
    {
        $this->dataSanitizer = $dataSanitizer;
    }

    public function getStockMovement(array $data) {
        try {
            $this->dataSanitizer->sanitizer($data);
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
