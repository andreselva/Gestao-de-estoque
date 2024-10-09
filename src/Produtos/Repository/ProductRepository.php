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

    public function saveProduct(Product $product): void
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

    public function getAllProducts(?array $data): array
    {
        try {
            $situation = $data['situation'] ?? null;
            $dateCreate = $data['dateCreate'] ?? null;

            $sql = "SELECT * FROM products WHERE 1=1";

            if ($situation && !in_array('T', $situation)) {
                if (!empty($situation)) {
                    // Monta a string de situações específicas para a consulta
                    $situationsList = implode("', '", $situation);
                    $sql .= " AND situacao IN ('$situationsList')";
                }
            }

            if ($dateCreate && !in_array('allDates', $dateCreate)) {

                $dateFilter = [
                    'lastyear' => "dataCriacao >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)",
                    'lastmonth' => "dataCriacao >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)",
                    'lastweek' => "dataCriacao >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)"
                ];

                foreach ($dateFilter as $key => $condition) {
                    if (in_array($key, $dateCreate)) {
                        $sql .= " AND " . $condition;
                        break;
                    }
                }
            }

            $stmt =  $this->connection->prepare($sql);

            if ($stmt->execute()) {
                $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $results;
            } else {
                return [];
            }
            
        } catch (Exception $e) {
            throw new Exception("An error ocurred " . $e->getMessage());
        }
    }

    public function findProductById(string $id): array
    {
        try {
            $sql = "SELECT * FROM products WHERE id=?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $id);

            if ($stmt->execute()) {
                $res = $stmt->fetch(\PDO::FETCH_ASSOC);
                return $res ?: []; // Retorna um array vazio se não houver resultados
            }
            return [];
        } catch (Exception $e) {
            throw new Exception("An error occurred " . $e->getMessage());
        }
    }

    public function saveProductEdit(Product $product): void
    {
        try {
            $sql = "UPDATE products SET name=?, codigo=?, precoVenda=?, un=?, pesoBruto=?, pesoLiquido=?, gtin=? WHERE id=?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $product->getName());
            $stmt->bindValue(2, $product->getCode());
            $stmt->bindValue(3, $product->getPrecoVenda());
            $stmt->bindValue(4, $product->getUn());
            $stmt->bindValue(5, $product->getPesoBruto());
            $stmt->bindValue(6, $product->getPesoLiquido());
            $stmt->bindValue(7, $product->getGtin());
            $stmt->bindValue(8, $product->getId());
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("An error ocurred " . $e->getMessage());
        }
    }

    public function getProductsDropdown(string $toSearch): array
    {
        try {
            $sql = "SELECT * FROM products WHERE codigo LIKE ? OR name LIKE ?";
            $stmt = $this->connection->prepare($sql);

            // Adiciona os '%' ao redor do termo de busca
            $searchTerm = '%' . $toSearch . '%';
            $stmt->bindValue(1, $searchTerm);
            $stmt->bindValue(2, $searchTerm);

            if ($stmt->execute()) {
                $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $results;
            }

            return [];
        } catch (Exception $e) {
            throw new Exception("An error occurred: " . $e->getMessage());
        }
    }
}
