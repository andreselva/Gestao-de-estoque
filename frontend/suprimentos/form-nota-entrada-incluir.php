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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <div id="main-content">
        <main>
            <section id="section-nota">
                <form id="form-nota-entrada" class="nota-entrada">
                    <h4>Nota de entrada</h4>
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
                            <input type="text" class="form-control" id="numero-nota" name="numero-nota">
                        </div>

                        <div class="col-2">
                            <label for="nome-empresa" class="form-label">Empresa</label>
                            <input type="text" class="form-control" id="nome-empresa" name="nome-empresa">
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="nat-oper" class="form-label">Natureza de operação</label>
                                <input type="text" class="form-control" id="nat-oper" name="nat-oper">
                            </div>
                            <div class="col-1">
                                <label for="numero-nota" class="form-label">Série</label>
                                <input type="text" class="form-control" id="numero-nota" name="numero-nota">
                            </div>

                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="dados-destinatario">
                        <div>
                            <h5>Dados do destinatário</h5>
                        </div>

                        <div class="row group-2">

                            <div class="row">
                                <div class="col-4">
                                    <label for="nome-dest" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome-dest" name="nome-dest">
                                </div>
                                <div class="col-2 col-type">
                                    <label for="pessoaTipo" class="form-label">Pessoa</label>
                                    <select class="form-select select-input" id="pessoaTipo">
                                        <option selected value="p-fisica">Física</option>
                                        <option value="p-juridica">Jurídica</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-2" id="cpfCnpjContainer">
                                    <label for="documentField" class="form-label" id="documentLabel">CPF</label>
                                    <input type="text" class="form-control" id="documentField" name="cpf-cnpj" placeholder="CPF ou CNPJ" maxlength="14">
                                </div>
                                <div class="col-2" id="ieField" style="display: none">
                                    <label for="ieField" class="form-label">Inscrição Estadual</label>
                                    <input type="text" class="form-control" id="ieField" placeholder="Digite a IE">
                                </div>
                                <div class="col-2" id="contribuinteField" style="display: none">
                                    <label for="identificadorField" class="form-label">Identificador</label>
                                    <select class="form-select" id="identificadorField">
                                        <option selected disabled value="">Selecione...</option>
                                        <option value="contribuinte">Contribuinte</option>
                                        <option value="nao-contribuinte">Não Contribuinte</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-2 type-cep">
                                    <label for="cep" class="form-label">CEP</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control inpt-cep" id="cep" name="cep">
                                        <button class="btn btn-outline-secondary btn-cep" type="button" id="button-addon1">
                                            <ion-icon class="icon" name="location-outline"></ion-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="endereco" class="form-label">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco">
                                </div>
                                <div class="col-1">
                                    <label for="numero-endereco" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="numero-endereco" name="numero-endereco">
                                </div>
                                <div class="col-2">
                                    <label for="complemento" class="form-label">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento">
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <label for="bairro" class="form-label">Bairro</label>
                                        <input type="text" class="form-control" id="bairro" name="bairro">
                                    </div>
                                    <div class="col-3">
                                        <label for="cidade" class="form-label">Cidade</label>
                                        <input type="text" class="form-control" id="cidade" name="cidade">
                                    </div>
                                    <div class="col-1 uf">
                                        <label for="uf" class="form-label">UF</label>
                                        <select class="form-select" id="uf">
                                            <option selected disabled value="">Selecione...</option>
                                            <option value="RS">RS</option>
                                            <option value="SC">SC</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label for="phone" class="form-label">Telefone</label>
                                        <input type="text" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>

                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="outro-endereco">
                        <div>
                            <h5>Endereço de entrega</h5>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="check-outro-endereco">
                            <label class="form-check-label" for="check-outro-endereco">
                                Usar outro endereço para entrega
                            </label>
                        </div>

                        <div class="row group-3" style="display: none" id="endereco-adicional">
                            <div class="col-4">
                                <label for="outro-dest" class="form-label">Destinatário</label>
                                <input type="text" class="form-control" id="outro-dest" name="outro-dest">
                            </div>
                            <div class="col-2 type-cep">
                                <label for="outro-cep" class="form-label">CEP</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control inpt-cep" id="outro-cep" name="outro-cep">
                                    <button class="btn btn-outline-secondary btn-cep" type="button" id="button-addon1">
                                        <ion-icon class="icon" name="location-outline"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row group-3" style="display: none" id="endereco-adicional-2">
                            <div class="col-4">
                                <label for="outro-endereco" class="form-label">Endereço</label>
                                <input type="text" class="form-control" id="outro-endereco" name="outro-endereco">
                            </div>
                            <div class="col-1">
                                <label for="outro-numero-endereco" class="form-label">Número</label>
                                <input type="text" class="form-control" id="outro-numero-endereco" name="outro-numero-endereco">
                            </div>
                            <div class="col-2">
                                <label for="outro-complemento" class="form-label">Complemento</label>
                                <input type="text" class="form-control" id="outro-complemento" name="outro-complemento">
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label for="outro-bairro" class="form-label">Bairro</label>
                                    <input type="text" class="form-control" id="outro-bairro" name="outro-bairro">
                                </div>
                                <div class="col-3">
                                    <label for="outra-cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="outra-cidade" name="outra-cidade">
                                </div>
                                <div class="col-1 uf">
                                    <label for="outra-uf" class="form-label">UF</label>
                                    <select class="form-select" id="outra-uf">
                                        <option selected disabled value="">Selecione...</option>
                                        <option value="RS">RS</option>
                                        <option value="SC">SC</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="itens-nota">

                    </div>


                </form>

            </section>
        </main>
    </div>
    <script src="./js/form-nota-entrada-controller.js"></script>
</body>

</html>