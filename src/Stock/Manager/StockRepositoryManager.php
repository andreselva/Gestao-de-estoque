<?php

namespace Andre\GestaoDeEstoque\Stock\Manager;

use Andre\GestaoDeEstoque\Stock\Repository\StockRepositoryInterface;
use Exception;

class StockRepositoryManager
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
    
    public function executeSearch(int $idProduto): array
    {
        return $this->connection->searchMovements($idProduto);
    }
}
