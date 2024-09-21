<?php

namespace Andre\GestaoDeEstoque\Actions;

use Andre\GestaoDeEstoque\Containers\ServiceContainer;
use Andre\GestaoDeEstoque\Stock\Controllers\StockController;

class SearchStockMovements implements ActionInterface
{
    private $stockController;

    public function __construct(ServiceContainer $container, StockController $stockController)
    {
        $container->register('buscar-lancamentos', $this);
        $this->stockController = $stockController;
    }

    public function execute(?array $data)
    {
        return $this->stockController->searchMovementsProduct($data);
    }
}
