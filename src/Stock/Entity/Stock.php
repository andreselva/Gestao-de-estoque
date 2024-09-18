<?php

namespace Andre\GestaoDeEstoque\Stock\Entity;

class Stock
{
    private int $id;
    private string $type;
    private float $cost;
    private int $quantity;
    private string $date;

    public function __construct($id, $type, $cost, $quantity, $date)
    {
        $this->id = $id;
        $this->type = $type;
        $this->cost = $cost;
        $this->quantity = $quantity;
        $this->date = $date;
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

    public function getId()
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    }
}
