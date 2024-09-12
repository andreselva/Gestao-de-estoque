<?php

namespace Andre\GestaoDeEstoque\Produtos\Repository;

use Andre\GestaoDeEstoque\Produtos\Entity\Product;

class ProductRepository implements ProductRepositoryInterface {
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function saveDatabase(Product $product)
    {
        
    }
}