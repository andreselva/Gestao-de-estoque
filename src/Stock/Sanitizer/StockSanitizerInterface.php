<?php

namespace Andre\GestaoDeEstoque\Stock\Sanitizer;

interface StockSanitizerInterface
{
    public function sanitizer(array $data): array;
}
