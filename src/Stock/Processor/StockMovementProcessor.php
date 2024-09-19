<?php
namespace Andre\GestaoDeEstoque\Stock\Processor;


use Andre\GestaoDeEstoque\Stock\CostCalculator\CostCalculatorInterface;

class StockMovementProcessor {

    private $calculator;
  

    public function __construct(CostCalculatorInterface $calculator)
    {
        $this->calculator = $calculator;
    }

    public function process(object $StockMovement): void 
    {
        if ($StockMovement->getCost() == '' || $StockMovement->getCost() == 0) {
            $cost = $this->calculator->calculateByItem(
            $StockMovement->getId(),
            $StockMovement->getQuantity(),
            $StockMovement->getPriceUn()
            );
            $StockMovement->setCost($cost);
        }
    }
}
    