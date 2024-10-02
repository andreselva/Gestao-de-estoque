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

function getSelectedFilters() {
    const filters = {};

    // Capturar filtros de "Situação"
    const situacaoCheckboxes = document.querySelectorAll('input[type="checkbox"][id^="sit"]');
    const situacoesSelecionadas = getSelectedCheckboxValues(situacaoCheckboxes);
    if (situacoesSelecionadas.length > 0) {
        filters.situacao = situacoesSelecionadas;
    }

    // Capturar filtros de "Data de Criação"
    const dataCheckboxes = document.querySelectorAll('input[type="checkbox"][id^="data"]');
    const datasSelecionadas = getSelectedCheckboxValues(dataCheckboxes);
    if (datasSelecionadas.length > 0) {
        filters.dataCriacao = datasSelecionadas;
    }

    return filters;
}

function getSelectedCheckboxValues(checkboxes) {
    return Array.from(checkboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);
}

// Função assíncrona para listar produtos e atualizar a tabela
async function listarProdutos(filters = {}) {
    try {

        // Parâmetros de consulta para listar produtos
        const params = new URLSearchParams({
            action: 'listar-produtos',
            situation: filters.situacao ? filters.situacao.join(', ') : '',
            dataCriacao: filters.dataCriacao ? filters.dataCriacao.join(', ') : ''
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
                    <div class="dropdown-action">
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


document.getElementById('applyFilters').addEventListener('click', () => {
    const selectedFilters = getSelectedFilters();
    listarProdutos(selectedFilters);
});



// Gerencia checkboxes para a seção "Situação"
document.getElementById('sitTodos').addEventListener('click', function () {
    // Seleciona todos os checkboxes de situação
    const situacaoCheckboxes = document.querySelectorAll('input[type="checkbox"][id^="sit"]:not(#sitTodos)');

    // Marca/desmarca os checkboxes com base no estado de "Todos"
    situacaoCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Adiciona evento de clique para os checkboxes de situação
const situacaoCheckboxes = document.querySelectorAll('input[type="checkbox"][id^="sit"]:not(#sitTodos)');
situacaoCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('click', function () {
        // Se qualquer checkbox de situação for desmarcado, desmarque o checkbox "Todos"
        if (!this.checked) {
            document.getElementById('sitTodos').checked = false;
        }
    });
});

// Gerencia checkboxes para a seção "Data de Criação"
document.getElementById('dataTodas').addEventListener('click', function () {
    const dataCheckboxes = document.querySelectorAll('input[type="checkbox"][id^="data"]:not(#dataTodas)');

    // Marca/desmarca os checkboxes com base no estado de "Todos"
    dataCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Adiciona evento de clique para os checkboxes de data
const dataCheckboxes = document.querySelectorAll('input[type="checkbox"][id^="data"]:not(#dataTodas)');
dataCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('click', function () {
        // Se qualquer checkbox de data for desmarcado, desmarque o checkbox "Todos"
        if (!this.checked) {
            document.getElementById('dataTodas').checked = false;
        }
    });
});


// DROPDOWN

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


document.addEventListener('DOMContentLoaded', () => {
    listarProdutos();

    // Delegação de eventos para links que abrem e fecham o modal
    document.querySelector('#produtos-list').addEventListener('click', (event) => {
        if (event.target && event.target.matches('#open-modal')) {
            event.preventDefault();
            selectedProductId = event.target.getAttribute('data-id');
            toggleModal(); // Abre o modal
        }
    });

});


// Prevenir o fechamento do dropdown ao clicar em checkboxes
const dropdownMenu = document.querySelector('.dropdown-menu');

dropdownMenu.addEventListener('click', function (event) {
    // Impede que o evento de clique propague e feche o dropdown
    event.stopPropagation();
});
