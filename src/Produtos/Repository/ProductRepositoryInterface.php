<?php

namespace Andre\GestaoDeEstoque\Produtos\Repository;

use Andre\GestaoDeEstoque\Produtos\Entity\Product;

interface ProductRepositoryInterface
{
    public function persist(Product $product);
}
