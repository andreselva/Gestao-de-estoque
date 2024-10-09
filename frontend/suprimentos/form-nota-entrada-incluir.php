<?php
require_once __DIR__ . '../../sidebar/sidebar.php';
require_once __DIR__ . '../../auth.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="../suprimentos/css/nota-entrada.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <div id="main-content">
        <main>
            <section id="section-nota">
                <form id="form-nota-entrada" class="nota-entrada">
                    <div class="row group-1">

                        <div class="col-2 col-date">
                            <label for="dataEntrada" class="form-label">Data de entrada</label>
                            <input type="date" class="form-control date-input" name="data-entrada">
                        </div>

                        <div class="col-2 col-type">
                            <label for="validationDefault04" class="form-label">Tipo</label>
                            <select class="form-select select-input" id="validationDefault04" required>
                                <option selected disabled value="">Selecione...</option>
                                <option value="Entrada">Entrada</option>
                                <option value="Devolucao">Devolução</option>
                            </select>
                        </div>

                        <div class="col-1">
                            <label for="numero-nota" class="form-label">Número</label>
                            <input type="text" class="form-control" name="numero-nota">
                        </div>

                        <div class="col-2">
                            <label for="nome-empresa" class="form-label">Empresa</label>
                            <input type="text" class="form-control" name="nome-empresa">
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="nat-oper" class="form-label">Natureza de operação</label>
                                <input type="text" class="form-control" name="nat-oper">
                            </div>
                            <div class="col-1">
                                <label for="numero-nota" class="form-label">Série</label>
                                <input type="text" class="form-control" name="numero-nota">
                            </div>

                        </div>
                    </div>

                    <div class="dados-destinatario">
                        <div>
                            <span>Dados do destinatário</span>
                        </div>

                        <div class="col-4">
                            <label for="data-entrada" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="data-entrada">
                        </div>

                    </div>


                </form>
            </section>
        </main>
    </div>
    <script src="./js/form-nota-entrada-controller.js"></script>
</body>

</html>