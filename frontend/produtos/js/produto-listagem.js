// Função para redirecionar para a página de adição de produtos
function goAddProducts(event) {
    event.preventDefault();
    window.location.href = "produtos-add.php";
}

// Função para redirecionar para a página de edição de um produto
function goToEdit(event) {
    event.preventDefault();
    const button = event.target;
    const id = button.getAttribute('data-id');
    window.location.href = `produtos-edit.php?id=${id}`;
}

// Função assíncrona para listar produtos e atualizar a tabela
async function listarProdutos() {
    try {
        // Parâmetros de consulta para listar produtos
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

        // Atualizar a tabela com produtos
        const tbody = document.querySelector('#produtos-list');
        tbody.innerHTML = ''; // Limpa o conteúdo atual da tabela

        produtos.forEach(produto => {
            const tr = document.createElement('tr');

            tr.innerHTML = `
                <td><input type="checkbox"></td>
                <td><a href="produtos-edit.php?id=${produto.id}">${produto.codigo}</a></td>
                <td><a href="produtos-edit.php?id=${produto.id}">${produto.name}</a></td>
                <td>${produto.estoque}</td>
                <td>
                    <div class="dropdown">
                        <button class="dropbtn" onclick="toggleDropdown(event)"><ion-icon name="menu-outline"></ion-icon></button>
                        <div class="dropdown-content">
                            <a href="produtos-edit.php?id=${produto.id}">Editar</a>
                            <a href="#" data-id="${produto.id}" onclick="confirmDelete(event)">Excluir</a>
                            <a href="#" data-id="${produto.id}" id="open-modal">Lançar estoque</a>
                        </div>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    } catch (error) {
        console.error('Erro ao listar produtos:', error);
    }
}

// Função para alternar a visibilidade do dropdown
function toggleDropdown(event) {
    event.stopPropagation(); // Evita que o clique se propague para outros elementos
    event.preventDefault();

    const button = event.currentTarget;
    const dropdown = button.nextElementSibling;

    // Fecha todos os dropdowns abertos
    document.querySelectorAll('.dropdown-content').forEach(content => {
        if (content !== dropdown) {
            content.classList.remove('show');
        }
    });

    // Alterna a visibilidade do dropdown atual
    dropdown.classList.toggle('show');
}

// Fecha os dropdowns ao clicar fora deles
window.addEventListener('click', (event) => {
    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-content').forEach(content => {
            content.classList.remove('show');
        });
    }
});
