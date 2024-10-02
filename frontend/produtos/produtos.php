<?php
require_once __DIR__ . '../../auth.php';
require_once __DIR__ . '../../suprimentos/estoque-modal.php';
require_once __DIR__ . '../../sidebar/sidebar.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="../produtos/css/produtos.css">
    <link rel="stylesheet" href="../produtos/css/dropdown-produtos.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
</head>

<body>
    <main>
        <form id="listagem-produto">
            <div id="btn-psq-cadastro">
                <div>
                    <button class="minimal-button" onclick="goAddProducts(event)">
                        Cadastrar
                    </button>
                </div>
                <div id="search-field">
                    <input type="text" class="minimal-search" placeholder="Pesquisar...">
                </div>
            </div>

            <div id="table-produtos">
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th class="columns-th">Produto</th>
                            <th class="columns-th">Estoque</th>
                            <th class="columns-th">#</th>
                        </tr>
                    </thead>
                    <tbody id="produtos-list">

                    </tbody>
                </table>
            </div>
        </form>
    </main>
    <script src="../produtos/js/produto-listagem.js"></script>
</body>

</html>