<?php
require_once __DIR__ . '../../auth.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
</head>

<body>
    <?php
    require_once __DIR__ . '../../src/header.php';
    ?>

    <main>
        <form>
            <div>
                <button>
                    Cadastrar
                </button>
            </div>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th>Checkbox</th>
                            <th>Produto</th>
                            <th>Estoque</th>
                            <th>#</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </form>
    </main>


</body>