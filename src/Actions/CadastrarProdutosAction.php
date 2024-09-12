<?php

namespace Andre\GestaoDeEstoque\Actions;

use Andre\GestaoDeEstoque\Containers\ServiceContainer;
use Andre\GestaoDeEstoque\Produtos\Controllers\ProductsController;

class CadastrarProdutosAction implements ActionInterface
{
    private $productController;

    public function __construct(ServiceContainer $container, ProductsController $productController)
    {
        $container->register('cadastrar-produto', $this);
        $this->productController = $productController;
    }

    public function execute(array $data)
    {
        return $this->productController->getProduct($data);
    }
}
