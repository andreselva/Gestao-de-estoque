<?php

namespace Andre\GestaoDeEstoque\Produtos\Repository;

use Andre\GestaoDeEstoque\Produtos\Entity\Product;
use Exception;

class ProductRepository implements ProductRepositoryInterface
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function persist(Product $product): void
    {
        try {
        } catch (Exception $e) {
        }
    }
}
