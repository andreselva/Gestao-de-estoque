<?php

namespace Andre\GestaoDeEstoque\Stock\Repository;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;
use Exception;

class StockRepository implements StockRepositoryInterface
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function executeTransaction(callable $operations)
    {
        try {
            // Iniciar transação
            $this->connection->beginTransaction();

            // Executar as operações passadas na callback
            $operations();

            // Se tudo deu certo, fazer o commit
            $this->connection->commit();
        } catch (Exception $e) {
            // Se houve erro, fazer rollback
            $this->connection->rollBack();
            throw $e; // Lançar exceção novamente para ser tratada na camada superior
        }
    }

    public function saveStockMovement(Stock $launch): bool
    {

        $sql = "INSERT INTO stock (idProduto, type, quantity, cost, date, priceUn) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $launch->getId());
        $stmt->bindValue(2, $launch->getType());
        $stmt->bindValue(3, $launch->getQuantity());
        $stmt->bindValue(4, $launch->getCost());
        $stmt->bindValue(5, $launch->getDate());
        $stmt->bindValue(6, $launch->getPriceUn());
        return $stmt->execute();
    }


    public function getLastDateBalance($idProduto)
    {
        try {
            $sql = "SELECT IFNULL(date, '2000-01-01 00:00:00') as dataBalanco
                FROM
                    stock
                WHERE type = 'B'
                AND idProduto = ?
                ORDER BY id DESC
                LIMIT 1";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $idProduto, \PDO::PARAM_INT);
            $stmt->execute();

            $dataBalanco = $stmt->fetchColumn();

            if ($dataBalanco) {
                return $dataBalanco;
            }
        } catch (Exception $e) {
            throw new Exception('An error ocurre while atualize stock of product.');
        }
    }

    public function getAllEntrances($idProduto, $dataBalanco)
    {
        try {
            $sql = "SELECT COALESCE(SUM(quantity), 0) as entradas FROM stock
                WHERE type = 'E'
                AND idProduto = ?
                AND date >= ? ";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $idProduto, \PDO::PARAM_INT);
            $stmt->bindValue(2, $dataBalanco, \PDO::PARAM_STR);
            $stmt->execute();

            $entradas = $stmt->fetchColumn();

            if ($entradas) {
                return $entradas;
            }
        } catch (Exception $e) {
            throw new Exception('An error ocurred...');
        }
    }

    public function getAllExits($idProduto, $dataBalanco)
    {
        try {
            $sql = "SELECT COALESCE(SUM(quantity), 0) as saidas FROM stock
            WHERE type = 'S'
            AND idProduto = ?
            AND date >= ? ";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $idProduto, \PDO::PARAM_INT);
            $stmt->bindValue(2, $dataBalanco, \PDO::PARAM_STR);
            $stmt->execute();

            $saidas = $stmt->fetchColumn();

            if ($saidas) {
                return $saidas;
            }
        } catch (Exception $e) {
            throw new Exception('an error...');
        }
    }

    public function getLastBalance($idProduto, $dataBalanco)
    {
        try {
            $sql = "SELECT quantity FROM stock WHERE type = 'B' AND idProduto = ? AND date = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $idProduto);
            $stmt->bindValue(2, $dataBalanco);
            $stmt->execute();

            $balance = $stmt->fetchColumn();

            if ($balance) {
                return $balance;
            }
        } catch (Exception $e) {
            throw new Exception('an error.');
        }
    }

    public function updateStock($idProduto, $novoEstoque): bool
    {
        $sql = "UPDATE products SET estoque = ? WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $novoEstoque);
        $stmt->bindValue(2, $idProduto);
        return $stmt->execute();
    }
}
