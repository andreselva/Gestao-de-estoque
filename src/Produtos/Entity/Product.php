<?php

namespace Andre\GestaoDeEstoque\Produtos\Entity;

use DateTime;

class Product
{
    private $id;
    private $name;
    private $code;
    private $dataCriacao;
    private $precoVenda;
    private $un;
    private $pesoBruto;
    private $pesoLiquido;
    private $gtin;

    public function __construct(
        string $name,
        string $code,
        string $dataCriacao,
        float $precoVenda,
        ?string $un,
        ?float $pesoBruto,
        ?float $pesoLiquido,
        ?string $gtin,
        ?string $id = ''
    ) {
        $this->name = $name;
        $this->code = $code;
        $this->dataCriacao = $dataCriacao;
        $this->precoVenda = $precoVenda;
        $this->un = $un;
        $this->pesoBruto = $pesoBruto;
        $this->pesoLiquido = $pesoLiquido;
        $this->gtin = $gtin;
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDataCriacao(): string
    {
        return $this->dataCriacao;
    }

    public function getPrecoVenda(): float
    {
        return $this->precoVenda;
    }

    public function getUn(): string
    {
        return $this->un;
    }

    public function getPesoBruto(): ?float
    {
        return $this->pesoBruto;
    }

    public function getPesoLiquido(): ?float
    {
        return $this->pesoLiquido;
    }

    public function getGtin(): ?string
    {
        return $this->gtin;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
