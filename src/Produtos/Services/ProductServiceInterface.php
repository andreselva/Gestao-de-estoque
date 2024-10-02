<?php

namespace Andre\GestaoDeEstoque\Produtos\Services;

interface ProductServiceInterface
{
    public function save(array $data);
    public function searchProducts(): array;
    public function searchOneProduct(array $data): array;
    public function sendProductForEdition(array $data): void;
    public function searchProductsForDropdown(array $data): array;
}
