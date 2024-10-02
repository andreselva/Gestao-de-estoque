<?php

namespace Andre\GestaoDeEstoque\Produtos\Controllers;

use Andre\GestaoDeEstoque\Produtos\Services\ProductServiceInterface;
use Exception;

class ProductsController
{
    private $productService;
    private const GOOD_REPONSE = ['status' => 'success'];

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function saveProduct(array $data): void
    {
        try {
            $this->productService->save($data);
            $this->sendJsonResponse(self::GOOD_REPONSE, 200);
        } catch (\InvalidArgumentException $e) {
            $this->sendJsonResponse(['status' => 'error', 'errorMsg' => $e->getMessage()], 400);
        } catch (Exception $e) {
            $this->sendJsonResponse(['status' => 'error', 'errorMsg' => $e->getMessage()], 500);
        }
    }

    public function getProducts(): void
    {
        try {
            $result = $this->productService->searchProducts();
            $this->sendJsonResponse($result, 200);
        } catch (Exception $e) {
            $this->sendJsonResponse(['status' => 'error', 'errorMsg' => $e->getMessage()], 500);
        }
    }

    public function loadProduct($data): void
    {
        try {
            $result = $this->productService->searchOneProduct($data);
            $this->sendJsonResponse($result, 200);
        } catch (Exception $e) {
            $this->sendJsonResponse(['status' => 'error', 'errorMsg' => $e->getMessage()], 500);
        }
    }

    public function editProduct($data): void
    {
        try {
            $this->productService->sendProductForEdition($data);
            $this->sendJsonResponse(self::GOOD_REPONSE, 200);
        } catch (Exception $e) {
            $this->sendJsonResponse(['status' => 'error', 'errorMsg' => $e->getMessage()], 500);
        }
    }

    public function getProductsForDropdown(array $data)
    {
        try {
            $result = $this->productService->searchProductsForDropdown($data);
            $this->sendJsonResponse($result, 200);
        } catch (Exception) {
        }
    }

    private function sendJsonResponse(array $array, $code): void
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($array);
        exit;
    }
}
