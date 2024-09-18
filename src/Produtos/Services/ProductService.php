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
        $sanitizedData = $this->sanitizer->ProductSanitizer($data);

        $product = new Product(
            $sanitizedData['name'],
            $sanitizedData['codigo'],
            $sanitizedData['dataCriacao'],
            $sanitizedData['precoVenda'],
            $sanitizedData['un'],
            $sanitizedData['pesoBruto'],
            $sanitizedData['pesoLiquido'],
            $sanitizedData['gtin']
        );
        
        $this->productRepository->saveProduct($product);
    }

    public function searchProducts(): array
    {
        $result = $this->productRepository->getAllProducts();
        return $result;
    }

    public function searchOneProduct(array $data): array
    {
        $idProduto = $data['idProduto'];
        $result = $this->productRepository->findProductById($idProduto);
        return $result;
    }

    public function sendProductForEdition($data): void
    {
        $sanitizedData = $this->sanitizer->productSanitizer($data);

        $product = new Product(
            $sanitizedData['name'],
            $sanitizedData['codigo'],
            $sanitizedData['dataCriacao'],
            $sanitizedData['precoVenda'],
            $sanitizedData['un'],
            $sanitizedData['pesoBruto'],
            $sanitizedData['pesoLiquido'],
            $sanitizedData['gtin'],
            $sanitizedData['id'],
        );

        $this->productRepository->saveProductEdit($product);
    }
}
