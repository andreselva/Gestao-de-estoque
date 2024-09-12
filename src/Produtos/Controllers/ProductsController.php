<?php

namespace Andre\GestaoDeEstoque\Produtos\Controllers;

use Andre\GestaoDeEstoque\Produtos\Services\ProductServiceInterface;

class ProductsController {
    private $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function getProduct(array $data) {
        
    }

}