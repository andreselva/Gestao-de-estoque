// Variáveis globais
let idProduto;  // Armazena o ID do produto selecionado
let searchTimeout;  // Armazena o timeout para a busca dos produtos

// Função para redirecionar para a página de inclusão de nota de entrada
function goToAddEntryNote(event) {
    event.preventDefault();
    window.location.href = "../suprimentos/form-nota-entrada-incluir.php";
}

// Evento de input para busca de produtos no dropdown
document.getElementById('produto').addEventListener('input', function () {
    const query = this.value;

    // Limpa o timeout anterior sempre que o usuário continuar digitando
    clearTimeout(searchTimeout);

    // Oculta o dropdown se a busca for menor que 2 caracteres
    if (query.length < 2) {
        document.getElementById('dropdownResultEstoque').style.display = 'none';
        return;
    }

    const params = new URLSearchParams({
        action: 'dropdown-produtos',
        search: `${query}`
    });

    // Inicia um novo timeout que vai esperar 300ms antes de fazer a requisição
    searchTimeout = setTimeout(() => {
        fetch(`../../src/index.php?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                const dropdown = document.getElementById('dropdownResultEstoque');
                dropdown.innerHTML = ''; // Limpa os resultados anteriores

                // Oculta o dropdown se não houver resultados
                if (data.length === 0) {
                    dropdown.style.display = 'none';
                    return;
                }

                // Exibe os primeiros 10 resultados
                const results = data.slice(0, 10);
                results.forEach(product => {
                    const div = document.createElement('div');
                    div.textContent = `${product.codigo} - ${product.name}`;
                    div.addEventListener('click', function () {
                        document.getElementById('produto').value = `${product.codigo} - ${product.name}`;
                        idProduto = `${product.id}`; // Guarda o ID do produto
                        dropdown.style.display = 'none'; // Oculta o dropdown
                    });
                    dropdown.appendChild(div); // Adiciona o produto ao dropdown
                });

                dropdown.style.display = 'block'; // Exibe o dropdown
            })
            .catch(error => {
                console.error('Erro ao buscar produtos:', error);
            });
    }, 300); // Delay de 300ms
});

// Evento para controlar a exibição de campos com base no tipo de pessoa selecionado (física ou jurídica)
document.addEventListener('DOMContentLoaded', function () {
    const pessoaTipo = document.getElementById('pessoaTipo');
    const documentField = document.getElementById('documentField');
    const documentLabel = document.getElementById('documentLabel');
    const ieField = document.getElementById('ieField');
    const contribuinteField = document.getElementById('contribuinteField');

    pessoaTipo.addEventListener('change', function () {
        const selectedValue = this.value;

        if (selectedValue === 'p-fisica') {
            // Altera o label e placeholder para CPF
            documentLabel.textContent = 'CPF';
            documentField.setAttribute('placeholder', 'Digite o CPF');
            documentField.setAttribute('maxlength', '14');
            documentField.setAttribute('pattern', '\\d{14}');

            // Oculta campos de IE e Contribuinte
            ieField.style.display = 'none';
            contribuinteField.style.display = 'none';

        } else if (selectedValue === 'p-juridica') {
            // Altera o label e placeholder para CNPJ
            documentLabel.textContent = 'CNPJ';
            documentField.setAttribute('placeholder', 'Digite o CNPJ');
            documentField.setAttribute('maxlength', '18');
            documentField.setAttribute('pattern', '\\d{14}');

            // Exibe campos de IE e Contribuinte
            ieField.style.removeProperty('display');
            contribuinteField.style.removeProperty('display');
        }
    });
});

// Evento para exibir ou ocultar campos de endereço adicional
document.getElementById('check-outro-endereco').addEventListener('change', function () {
    const enderecoAdicional = document.getElementById('endereco-adicional');
    const enderecoAdicional2 = document.getElementById('endereco-adicional-2');

    // Verifica se o checkbox foi marcado
    if (this.checked) {
        enderecoAdicional.style.removeProperty('display');  // Exibe os campos
        enderecoAdicional2.style.removeProperty('display');
    } else {
        enderecoAdicional.style.display = 'none';  // Oculta os campos
        enderecoAdicional2.style.display = 'none';
    }
});

// Evento para adicionar itens à tabela
document.getElementById('adicionar-item').addEventListener('click', function () {
    // Captura os valores dos campos
    const produto = document.getElementById('produto').value;
    const quantidade = document.getElementById('quantidade').value;
    const preco = document.getElementById('preco').value;

    // Cabeçalho da tabela (adicionado apenas uma vez)
    const headTable = `
        <thead id="tabela-head">
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Total</th>
                <th>Ações</th>
            </tr>
        </thead>`;

    // Verifica se os campos estão preenchidos
    if (produto && quantidade && preco) {
        const tabela = document.getElementById('tabela-itens');
        // Adiciona o cabeçalho se ainda não existir
        if (!document.getElementById('tabela-head')) {
            tabela.insertAdjacentHTML('afterbegin', headTable);
        }

        // Calcula o total (quantidade * preço)
        const total = (quantidade * preco).toFixed(2);

        // Cria uma nova linha na tabela
        const novaLinha = `
            <tr idProduto="${idProduto}">
                <td>${produto}</td>
                <td>${quantidade}</td>
                <td>${preco}</td>
                <td>${total}</td>
                <td><button class="btn btn-danger btn-sm remover-item">Remover</button></td>
            </tr>`;

        // Insere a nova linha no corpo da tabela
        document.getElementById('corpo-tabela-itens').insertAdjacentHTML('beforeend', novaLinha);

        // Limpa os campos após adicionar o item
        document.getElementById('produto').value = '';
        document.getElementById('quantidade').value = '';
        document.getElementById('preco').value = '';
    } else {
        alert('Preencha todos os campos antes de adicionar um item!');
    }
});

// Evento para remover itens da tabela
document.getElementById('tabela-itens').addEventListener('click', function (e) {
    if (e.target.classList.contains('remover-item')) {
        e.target.closest('tr').remove();  // Remove a linha correspondente

        // Verifica se ainda há itens na tabela
        const corpoTabela = document.getElementById('corpo-tabela-itens');
        if (corpoTabela.children.length === 0) {
            // Remove o cabeçalho se não houver mais itens
            const tabelaHead = document.getElementById('tabela-head');
            if (tabelaHead) {
                tabelaHead.remove();
            }
        }
    }
});
