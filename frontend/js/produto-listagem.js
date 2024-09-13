function goAddProducts(event) {
    event.preventDefault();
    window.location.href = "produtos-add.php";
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
                <td><a href="produtos-edit.php?id=${produto.id}">${produto.name}</a></td>
                <td>${produto.estoque}</td>
                <td><button class="minimal-button" onclick="editarProduto(${produto.id})">Editar</button></td>
            `;

            tbody.appendChild(tr);
        });
    } catch (error) {
        console.error('Erro ao listar produtos:', error);
    }
}

// Chama a função listarProdutos ao carregar a página
document.addEventListener('DOMContentLoaded', listarProdutos);