function cancel(event) {
    event.preventDefault();
    window.location.href = "produtos.php";
}

async function cadastrarProduto(event) {
    event.preventDefault();
    form = document.querySelector('#cadastro-produto');

    try {
        const formData = new FormData(form);
        formData.append('action', 'cadastrar-produto');
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
        })
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