<?php
require_once __DIR__ . '../../auth.php';
require_once __DIR__ . '../../sidebar/sidebar.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="../suprimentos/css/estoque.css">
</head>

<body>


    <main>
        <section id="estoque">
            <div id="container">
                <div>
                    <button id="open-modal" class="minimal-button">
                        Incluir lançamento
                    </button>
                </div>
                <div id="search-field">
                    <input type="text" class="minimal-search" id="search-input" placeholder="Pesquisar...">
                    <div id="dropdownResultEstoque"></div>
                </div>
            </div>
            <div id="tabela-lancamentos">
                <table id="lancamentosTable" style="display: none;">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Tipo de Lançamento</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </section>



        <script src="./js/estoque.js"></script>
</body>

</html>