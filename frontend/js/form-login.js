function cadastrarNovoUsuario(event) {
    event.preventDefault();
    window.location.href = './../cadastro/cadastro.php'
}


async function autenticarUsuario(event) {
    event.preventDefault();
    const form = document.querySelector('#login-form');

    try {

        const formData = new FormData(form);
        formData.append('action', 'autenticar-usuario');
        const data = {};

        formData.forEach((value, key) => {
            data[key] = value;
        });

        const response = await fetch('../../src/index.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const responseData = await response.json();

        if (responseData.status === "success") {
            window.location.href = "./../src/index.php";
        } else {
            window.location.href = "login.php?error=true";
        }

    } catch (error) {
        console.error('Erro ao realizar a autenticação:', error);
        alert('Ocorreu um erro ao realizar a autenticação. Tente novamente.');
    }
}