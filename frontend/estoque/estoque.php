<?php
require_once __DIR__ . '../../auth.php';
require_once __DIR__ . '../../src/sidebar.php';
require_once 'estoque-modal.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="../css/estoque.css">
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
                    <input type="text" class="minimal-search" placeholder="Pesquisar...">
                </div>
                <div>
                </div>
            </div>
        </section>

</body>

</html>