<?php

namespace Andre\GestaoDeEstoque\Actions;

use Andre\GestaoDeEstoque\Containers\ServiceContainer;
use Andre\GestaoDeEstoque\Produtos\Controllers\ProductsController;

class ListProductsFromDropdownStock implements ActionInterface
{
    private $productController;

    public function __construct(ServiceContainer $container, ProductsController $productController)
    {
        $container->register('dropdown-produtos', $this);
        $this->productController = $productController;
    }

    public function execute(?array $data)
    {
        return $this->productController->getProductsForDropdown($data);
    }
}
