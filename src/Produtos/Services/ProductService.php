<?php

namespace Andre\GestaoDeEstoque\Produtos\Services;

use Andre\GestaoDeEstoque\Produtos\Entity\Product;
use Andre\GestaoDeEstoque\Produtos\Repository\ProductRepositoryInterface;
use Andre\GestaoDeEstoque\Validation\DataSanitizer;
use DateTime;

class ProductService implements ProductServiceInterface
{
    private $productRepository;
    private $sanitizer;

    public function __construct(ProductRepositoryInterface $productRepository, DataSanitizer $sanitizer)
    {
        $this->productRepository = $productRepository;
        $this->sanitizer = $sanitizer;
    }

    public function save(array $data): void
    {
        $name = $this->sanitizer->sanitizeName($data['name']);
        $codigo = $this->sanitizer->sanitize($data['codigo']);
        $dataCriacao = (new DateTime())->format('Y-m-d H:i:s');
        $precoVenda = $this->sanitizer->sanitizeDecimal($data['preco-venda']) ?? 0;
        $un = $this->sanitizer->sanitize($data['un']);
        $pesoBruto = $this->sanitizer->sanitizeDecimal($data['peso-bruto']);
        $pesoLiquido = $this->sanitizer->sanitizeDecimal($data['peso-liquido']);
        $gtin = $this->sanitizer->sanitize($data['gtin']);


        if ($precoVenda <= 0) {
            throw new \InvalidArgumentException('Price cannot be negative or equal to zero.');
        }

        if ($pesoBruto < 0 || $pesoLiquido < 0) {
            throw new \InvalidArgumentException('Gross weight or net weight cannot be less than zero.');
        }

        $product = new Product($name, $codigo, $dataCriacao, $precoVenda, $un, $pesoBruto, $pesoLiquido, $gtin);
        $this->productRepository->persist($product);
    }

    public function searchProducts(): array
    {
        $result = $this->productRepository->search();
        return $result;
    }

    public function searchOneProduct(array $data): array
    {
        $idProduto = $data['idProduto'];
        $result = $this->productRepository->searchProduct($idProduto);
        return $result;
    }
}
