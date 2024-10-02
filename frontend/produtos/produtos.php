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
    <link rel="stylesheet" href="../produtos/css/table.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
                <div class="group-action">
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Filtrar
                        </a>
                        <div class="dropdown-menu p-3" style="width: 300px;">
                            <!-- Seção de Situação -->
                            <h6 class="dropdown-header">Situação</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sitTodos">
                                <label class="form-check-label" for="sitTodos">Todos</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="A" id="sitAtivos">
                                <label class="form-check-label" for="sitAtivos">Ativos</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="I" id="sitInativos">
                                <label class="form-check-label" for="sitInativos">Inativos</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="E" id="sitExcluidos">
                                <label class="form-check-label" for="sitExcluidos">Excluídos</label>
                            </div>

                            <!-- Separador -->
                            <hr class="dropdown-divider">

                            <!-- Seção de Data de Criação -->
                            <h6 class="dropdown-header">Data de criação</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="todas" id="dataTodas">
                                <label class="form-check-label" for="dataTodas">Qualquer</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="lastweek" id="dataSemana">
                                <label class="form-check-label" for="dataSemana">Última semana</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="lastmonth" id="dataMes">
                                <label class="form-check-label" for="dataMes">Último mês</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="lastyear" id="dataAno">
                                <label class="form-check-label" for="dataAno">Último ano</label>
                            </div>

                            <!-- Botão para Aplicar os Filtros -->
                            <div class="d-grid gap-2 mt-3">
                                <button class="minimal-button" id="applyFilters">Filtrar</button>
                            </div>
                        </div>
                    </div>

                    <div id="search-field" class="form-group medium-input">
                        <input type="text" placeholder="Pesquisar...">
                    </div>
                </div>
            </div>

            <div id="table-produtos">
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th class="columns-th">Código</th>
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