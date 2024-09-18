<?php

namespace Andre\GestaoDeEstoque\Stock\Factorys;

use Andre\GestaoDeEstoque\Stock\Entity\Stock;
use DateTime;
use DateTimeZone;

class StockFactory
{
    public function __construct() {}

    public static function create(array $data): Stock
    {
        $dateTime = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        // Formata a data e hora
        $formattedDate = $dateTime->format('Y-m-d H:i:s');

        return new Stock(
            $data['idProduto'],
            $data['type'],
            $data['cost'],
            $data['quantity'],
            $formattedDate

        );
    }
}
