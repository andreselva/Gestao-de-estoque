<?php

namespace Andre\GestaoDeEstoque\Stock\Entity;

class Stock
{
    private int $type;
    private float $cost;
    private int $quantity;

    public function __construct($type, $cost, $quantity)
    {
        $this->type = $type;
        $this->cost = $cost;
        $this->quantity = $quantity;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
