<?php

namespace Andre\GestaoDeEstoque\Produtos\Repository;

use Andre\GestaoDeEstoque\Produtos\Entity\Product;
use Exception;

class ProductRepository implements ProductRepositoryInterface
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function persist(Product $product): void
    {
        try {
            $sql = "INSERT INTO products (name, codigo, dataCriacao, precoVenda, un, pesoBruto, pesoLiquido, gtin) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $product->getName());
            $stmt->bindValue(2, $product->getCode());
            $stmt->bindValue(3, $product->getDataCriacao());
            $stmt->bindValue(4, $product->getPrecoVenda());
            $stmt->bindValue(5, $product->getUn());
            $stmt->bindValue(6, $product->getPesoBruto());
            $stmt->bindValue(7, $product->getPesoLiquido());
            $stmt->bindValue(8, $product->getGtin());
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("An error ocurred:" . $e->getMessage());
        }
    }

    public function search(): array
    {
        try {
            $sql = "SELECT * FROM products";
            $stmt =  $this->connection->prepare($sql);

            if ($stmt->execute()) {
                // Busque todos os resultados em um array associativo
                $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $results;
            } else {
                // Em caso de erro, você pode lidar com isso aqui
                return [];
            }
        } catch (Exception $e) {
            throw new Exception("An error ocurred" . $e->getMessage());
        }
    }
}
