<?php

namespace Andre\GestaoDeEstoque\Actions;

use Andre\GestaoDeEstoque\Containers\ServiceContainer;
use Andre\GestaoDeEstoque\Stock\Controllers\StockController;

class LancarEstoqueAction implements ActionInterface
{
    private $stockController;

    public function __construct(ServiceContainer $container, StockController $stockController)
    {
        $container->register('lancar-estoque', $this);
        $this->stockController = $stockController;
    }

    public function execute(?array $data)
    {
        $this->stockController->getStockMovement($data);
    }
}
