<?php

namespace Andre\GestaoDeEstoque\Actions;

use Andre\GestaoDeEstoque\Containers\ServiceContainer;
use Andre\GestaoDeEstoque\Produtos\Controllers\ProductsController;

class ListarProdutosAction implements ActionInterface
{
    private $productController;

    public function __construct(ServiceContainer $container, ProductsController $productController)
    {
        $container->register('listar-produtos', $this);
        $this->productController = $productController;
    }

    public function execute(?array $data)
    {
        return $this->searchData($data);
    }

    private function searchData($data)
    {
        return $this->productController->getProducts($data);
    }
}
