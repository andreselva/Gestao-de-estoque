<?php

namespace Andre\GestaoDeEstoque\Produtos\Services;

use Andre\GestaoDeEstoque\Produtos\Repository\ProductRepositoryInterface;

class ProductService implements ProductServiceInterface
{

    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    
    public function save(array $data) {}
}
