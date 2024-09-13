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
        <form id="editar-produto">
            <div id="input-group-1">
                <div class="form-group large-input">
                    <label>Nome do produto</label>
                    <input type="text" name="name" id="name">
                </div>
                <div class="form-group medium-input">
                    <label>Código</label>
                    <input type="text" name="codigo" id="codigo">
                </div>
                <div class="form-group medium-input">
                    <label>Data e hora da criação</label>
                    <input type="text" readonly id="data-criacao">
                </div>
            </div>
            <div id="input-group-1">
                <div class="form-group medium-input">
                    <label>Preço de venda</label>
                    <input type="text" name="preco-venda" id="preco-venda">
                </div>
                <div class="form-group medium-input">
                    <label>Unidade</label>
                    <input type="text" name="un" id="un">
                </div>
                <div class="form-group medium-input">
                    <label>Peso bruto</label>
                    <input type="text" name="peso-bruto" id="peso-bruto">
                </div>
                <div class="form-group medium-input">
                    <label>Peso líquido</label>
                    <input type="text" name="peso-liquido" id="peso-liquido">
                </div>
            </div>
            <div id="input-group-1">
                <div class="form-group medium-input">
                    <label>GTIN</label>
                    <input type="text" name="gtin" id="gtin">
                </div>
            </div>
            <div class="buttons">
                <div>
                    <button class="minimal-button" onclick="editarProduto(event)">
                        Salvar
                    </button>
                </div>
                <div>
                    <button class="minimal-button" onclick="cancelEdit(event)">
                        Cancelar
                    </button>
                </div>
            </div>
        </form>
    </main>
    <script src="../js/produto-edit.js"></script>
</body>

</html>