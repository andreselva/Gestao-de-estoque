// Variáveis globais
let idProduto;  // Armazena o ID do produto selecionado
let searchTimeout;  // Armazena o timeout para a busca dos produtos
let estoqueDisponivel; // Armazena o estoque disponível do produto
// let paramPermiteEstNegativo; // Armazena o valor do parâmetro, se permite estoque negativo.
let produtos = []; // Array para armazenar os produtos

// Função para redirecionar para a página de inclusão de nota de entrada
function goToAddEntryNote(event) {
    event.preventDefault();
    window.location.href = "../notafiscal/form-nota-entrada-incluir.php";
}


// async function getParamValue() {
//     const params = new URLSearchParams({
//         action: 'getParamValue',
//         search: 'permiteEstoqueNegativo'
//     });

//     try {
//         const response = await fetch(`../../src/index.php?${params.toString()}`);
//         const data = await response.json();
//         return data.param; // Retorna o valor do parâmetro
//     } catch (error) {
//         console.error('Erro ao buscar o valor do parâmetro:', error);
//         return null; // Valor padrão em caso de erro
//     }
// }

// // Função para carregar o parâmetro ao abrir a página
// async function carregarParametro() {
//     paramPermiteEstNegativo = await getParamValue(); // Armazena o valor na variável global
//     console.log('Parâmetro carregado:', paramPermiteEstNegativo);
// }

// // Carrega o parâmetro assim que a página for aberta
// document.addEventListener('DOMContentLoaded', carregarParametro);



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
                        estoqueDisponivel = Number(product.estoque);
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

        // Verifica se o produto já existe na tabela
        const linhas = document.querySelectorAll('#corpo-tabela-itens tr');
        let produtoExistente = false;

        linhas.forEach(linha => {
            const tdProduto = linha.querySelector('td:first-child').textContent;

            // Se o produto já existe, soma a quantidade
            if (tdProduto === produto) {
                const tdQuantidade = linha.querySelector('td:nth-child(2)');
                const tdTotal = linha.querySelector('td:nth-child(4)');

                // Atualiza a quantidade
                const novaQuantidade = Number(tdQuantidade.textContent) + Number(quantidade);
                tdQuantidade.textContent = novaQuantidade;

                // Atualiza o total
                const novoTotal = (novaQuantidade * preco).toFixed(2);
                tdTotal.textContent = novoTotal;

                // Atualiza o array de produtos
                const produtoIndex = produtos.findIndex(p => p.nome === produto);
                if (produtoIndex !== -1) {
                    produtos[produtoIndex].quantidade = novaQuantidade; // Atualiza a quantidade
                    produtos[produtoIndex].total = novoTotal; // Atualiza o total
                }

                produtoExistente = true; // Indica que o produto já existe
            }
        });

        // Se o produto não existe, adiciona uma nova linha e adiciona ao array
        if (!produtoExistente) {
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

            // Adiciona o produto ao array
            produtos.push({
                idProduto: idProduto,
                nome: produto,
                quantidade: Number(quantidade),
                preco: Number(preco),
                total: total
            });
        }

        // Limpa os campos após adicionar o item e seta o idProduto como 0
        document.getElementById('produto').value = '';
        document.getElementById('quantidade').value = '';
        document.getElementById('preco').value = '';
        idProduto = 0;
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


async function salvarNotaFiscal(event) {
    event.preventDefault();

    if (!verificaCampos()) return;

    const form = document.getElementById('form-nota-entrada');

    try {
        const formData = new FormData(form);
        formData.append('action', 'cadastrar-nota-entrada');

        // Adiciona os produtos ao formData
        formData.append('produtos', JSON.stringify(produtos)); // Converte o array para string

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

        const responseData = await response.json();
        console.log(responseData); // Você pode manipular a resposta como necessário

    } catch (error) {
        console.error('Erro ao salvar nota fiscal:', error);
    }
}

function verificaCampos() {
    const checkbox = document.getElementById('check-outro-endereco');

    const validarCampos = (campos) => {
        for (let campo of campos) {
            const elemento = document.getElementById(campo);
            if (!elemento || elemento.value.trim() === '' || elemento.value === 'Selecione...') { // Verifica se o elemento existe
                const label = document.querySelector(`label[for="${campo}"]`);
                const nomeCampo = label ? label.textContent : campo;
                alert(`Verifique o campo '${nomeCampo}'`); // Mensagem de erro
                return false;
            }
        }
        return true; // Todos os campos estão preenchidos
    }

    // Verifica campos condicionais se o checkbox estiver marcado
    if (checkbox.checked && !validarCampos([
        'outro-dest',
        'outro-cep',
        'outro-endereco',
        'outro-numero-endereco',
        'outro-complemento',
        'outro-bairro',
        'outra-cidade',
        'outra-uf-dest'
    ])) {
        return false; // Se os campos condicionais não estiverem preenchidos, retorna false
    }

    // Verifica campos gerais
    return validarCampos([
        'tipo-entrada',
        'numero-nota',
        'nome-empresa',
        'nat-oper',
        'serie-nota',
        'nome-dest',
        'pessoaTipo',
        'cpf-cnpj',
        'ieField',
        'identificador-ie',
        'cep',
        'endereco',
        'numero-endereco',
        'complemento',
        'bairro',
        'cidade',
        'uf-dest',
        'telefone',
        'email',
    ]);
}
