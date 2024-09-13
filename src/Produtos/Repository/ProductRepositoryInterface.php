<?php

namespace Andre\GestaoDeEstoque\Produtos\Repository;

use Andre\GestaoDeEstoque\Produtos\Entity\Product;

interface ProductRepositoryInterface
{
    public function persist(Product $product);
    public function search(): array;
    public function searchProduct(string $id): array;
}
