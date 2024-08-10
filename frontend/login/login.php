<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <header>

    </header>
    <main>
        <div id="form-login">
            <form id="login-form">
                <div id="componentes-form">

                    <div>
                        <h2>Autentique-se</h2>
                    </div>

                    <div id="componentes-lgn">
                        <div id="comp-nome" class="input-group">
                            <input required="" type="text" name="username" autocomplete="off" class="input">
                            <label class="user-label">Nome de usuário</label>
                        </div>
                        <div id="comp-sen" class="input-group">
                            <input required="" type="password" name="password" autocomplete="off" class="input">
                            <label class="user-label">Senha</label>
                        </div>
                        <div id="comp-btn">
                            <div>
                                <button id="btn-entrar" class="buttons" onclick="autenticarUsuario(event)">Entrar</button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button id="btn-cadastrar" class="buttons2" onclick="cadastrarNovoUsuario(event)">Cadastre-se</button>
                    </div>

                </div>
            </form>
        </div>
    </main>
    <footer>

    </footer>
    <script src="form-login.js"></script>
</body>

</html>