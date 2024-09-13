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
        const responseData = await response.json();

        if (responseData.status === 'success') {
            alert("Produto cadastrado com sucesso.");
            window.location.href = 'produtos.php';
        } else if (responseData.status === 'error') {
            alert(`Ocorreu um erro ao cadastrar produto. Erro: ${responseData.errorMsg}`);
            window.location.reload();
        }

    } catch (error) {
        console.error('Erro ao realizar o cadastro:', error);
        alert('Ocorreu um erro ao realizar o cadastro. Tente novamente.');
    }

}