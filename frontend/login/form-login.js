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

        const responseText = await response.text();
        console.log('Resposta bruta do servidor:', responseText);

        if (responseText) {
            const responseData = JSON.parse(responseText);
            console.log('Cadastro realizado com sucesso:', responseData);
        } else {
            console.error('Resposta vazia recebida do servidor');
            alert('O servidor retornou uma resposta vazia.');
        }
    } catch (error) {
        console.error('Erro ao realizar o cadastro:', error);
        alert('Ocorreu um erro ao realizar o cadastro. Tente novamente.');
    }
}