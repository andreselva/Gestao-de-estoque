<?php
require_once __DIR__ . '../../auth.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="../css/produtos.css">
</head>

<body>
    <?php
    require_once __DIR__ . '../../src/sidebar.php';
    ?>

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
                            <th>Produto</th>
                            <th>Estoque</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody id="produtos-list">
                       
                    </tbody>
                </table>
            </div>
        </form>
    </main>
    <script src="../js/produto-cadastro.js"></script>
</body>

</html>