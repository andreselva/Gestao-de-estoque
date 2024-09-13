<?php

namespace Andre\GestaoDeEstoque\Produtos\Services;

interface ProductServiceInterface
{
    public function save(array $data);
    public function searchProducts(): array;
}
