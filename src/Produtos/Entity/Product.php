<?php

namespace Andre\GestaoDeEstoque\Produtos\Entity;

class Product
{
    private $name;
    private $code;
    private $dataCriacao;
    private $precoVenda;
    private $un;
    private $pesoBruto;
    private $pesoLiquido;
    private $gtin;

    public function __construct($name, $code, $dataCriacao, $precoVenda, $un, $pesoBruto, $pesoLiquido, $gtin)
    {
        $this->name = $name;
        $this->code = $code;
        $this->dataCriacao = $dataCriacao;
        $this->precoVenda = $precoVenda;
        $this->un = $un;
        $this->pesoBruto = $pesoBruto;
        $this->pesoLiquido = $pesoLiquido;
        $this->gtin = $gtin;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    public function getPrecoVenda()
    {
        return $this->precoVenda;
    }

    public function getUn()
    {
        return $this->un;
    }

    public function getPesoBruto()
    {
        return $this->pesoBruto;
    }

    public function getPesoLiquido()
    {
        return $this->pesoLiquido;
    }

    public function getGtin()
    {
        return $this->gtin;
    }
}
