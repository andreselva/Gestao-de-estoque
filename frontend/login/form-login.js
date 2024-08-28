function cadastrarNovoUsuario(event) {
    event.preventDefault();
    window.location.href = './../cadastro/cadastro.html'
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

        if (responseText) {
            try {
                const responseData = JSON.parse(responseText);
                console.log('Resposta JSON analisada:', responseData);
        
            } catch (error) {
                console.error('Erro ao analisar o JSON:', error);
            }
        } else {
            console.error('Resposta vazia recebida do servidor');
            alert('O servidor retornou uma resposta vazia.');
        }
    } catch (error) {
        console.error('Erro ao realizar a autenticação:', error);
        alert('Ocorreu um erro ao realizar a autenticação. Tente novamente.');
    }
}