<?php

namespace Andre\GestaoDeEstoque\Produtos\Controllers;

use Andre\GestaoDeEstoque\Produtos\Services\ProductServiceInterface;
use Exception;

class ProductsController
{
    private $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function getProduct(array $data): void
    {
        try {
            $this->productService->save($data);
            $this->sendJsonResponse(['status' => 'success'], 200);
        } catch (\InvalidArgumentException $e) {
            $this->sendJsonResponse(['status' => 'error', 'error-msg' => $e->getMessage()], 400);
        } catch (Exception $e) {
            $this->sendJsonResponse(['status' => 'error', 'error-msg' => $e->getMessage()], 500);
        }
    }

    public function getProducts()
    {
        try {
            $result = $this->productService->searchProducts();
            $this->sendJsonResponse($result, 200);
        } catch (Exception $e) {
            $this->sendJsonResponse(['status' => 'error', 'error-msg' => $e->getMessage()], 500);
        }
    }

    private function sendJsonResponse(array $array, $code)
    {
        http_response_code($code);
        echo json_encode($array);
        exit;
    }
}
