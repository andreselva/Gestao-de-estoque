function goAddProducts(event) {
    event.preventDefault();
    window.location.href = "produtos-add.php";
}

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


async function listarProdutos() {
    try {
        // Parâmetros de consulta
        const params = new URLSearchParams({
            action: 'listar-produtos'
        });

        // Fazer uma requisição GET com parâmetros de consulta
        const response = await fetch(`../../src/index.php?${params.toString()}`);

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        // Converter a resposta para JSON
        const produtos = await response.json();

        // Atualizar a tabela
        const tbody = document.querySelector('#produtos-list');
        tbody.innerHTML = ''; // Limpa o conteúdo atual da tabela

        produtos.forEach(produto => {
            const tr = document.createElement('tr');

            tr.innerHTML = `
                <td><input type="checkbox"></td>
                <td>${produto.name}</td>
                <td>${produto.estoque}</td>
                <td><button onclick="editarProduto(${produto.id})">Editar</button></td>
            `;

            tbody.appendChild(tr);
        });
    } catch (error) {
        console.error('Erro ao listar produtos:', error);
    }
}

function editarProduto(id) {
    // Implementar a lógica para editar o produto
    console.log('Editar produto com ID:', id);
}

// Chama a função listarProdutos ao carregar a página
document.addEventListener('DOMContentLoaded', listarProdutos);