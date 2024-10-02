function cancelEdit(event) {
    event.preventDefault();
    window.location.href = "produtos.php";
}

async function carregarProduto(id) {
    try {
        // Parâmetros de consulta
        const params = new URLSearchParams({
            action: 'buscar-produto',
            id: id
        });

        // Fazer uma requisição GET com parâmetros de consulta
        const response = await fetch(`../../src/index.php?${params.toString()}`);

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        // Converter a resposta para JSON
        const produto = await response.json();

        // Verificar a estrutura do objeto
        if (produto && typeof produto === 'object') {
            document.getElementById('name').value = produto.name;
            document.getElementById('codigo').value = produto.codigo;
            document.getElementById('data-criacao').value = produto.dataCriacao;
            document.getElementById('preco-venda').value = produto.precoVenda;
            document.getElementById('un').value = produto.un;
            document.getElementById('peso-bruto').value = produto.pesoBruto;
            document.getElementById('peso-liquido').value = produto.pesoLiquido;
            document.getElementById('gtin').value = produto.gtin;
        } else {
            console.error('O formato da resposta não é um objeto:', produto);
        }
    } catch (error) {
        console.error('Erro ao carregar produto:', error);
    }
}

async function editarProduto(event) {
    event.preventDefault();
    form = document.querySelector('#editar-produto');
    const id = produtoId;

    try {
        const formData = new FormData(form);
        formData.append('action', 'editar-produto');
        formData.append('idProduto', id);
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




let produtoId = null;

document.addEventListener('DOMContentLoaded', () => {
    // Capturar o ID do produto da URL
    const urlParams = new URLSearchParams(window.location.search);
    produtoId = urlParams.get('id');

    if (produtoId) {
        // Chama a função carregarProduto com o ID do produto
        carregarProduto(produtoId);
    } else {
        console.error('ID do produto não encontrado na URL');
    }
});
