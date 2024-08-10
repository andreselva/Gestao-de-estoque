<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="cadastro.css">
</head>

<body>
    <header>

    </header>
    <main>
        <div id="form-login">
            <form id="form-cadastro">
                <div id="btn-voltar">
                    <button class="buttons" onclick="retornaLogin(event)">
                        <svg width="25px" height="25px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#000000" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"></path>
                            <path fill="#000000"
                                d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z">
                            </path>
                        </svg>
                    </button>
                </div>
                <div id="componentes-form">

                    <div>
                        <h2>Cadastrar</h2>
                    </div>

                    <div id="componentes-lgn">
                        <div id="comp-nome" class="input-group">
                            <input required="" type="name" name="username" autocomplete="off" class="input">
                            <label class="user-label">Nome de usuário</label>
                        </div>
                        <div id="comp-e-mail" class="input-group">
                            <input required="" type="email" name="email" autocomplete="off" class="input">
                            <label class="user-label">E-mail</label>
                        </div>
                        <div id="comp-sen" class="input-group">
                            <input required="" type="password" name="password" autocomplete="off" class="input">
                            <label class="user-label">Senha</label>
                        </div>
                        <div id="comp-btn">
                            <div>
                                <button class="buttons" id="btn-cadastrar" onclick="realizaCadastro(event)">Cadastrar</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </main>
    <footer>

    </footer>
    <script src="form-cadastro.js"></script>
</body>

</html>