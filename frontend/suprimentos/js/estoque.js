let searchTimeout; // Variável para armazenar o timeout
let idProduto; // Variável para armazenar o id do produto clicado

document.getElementById('search-input').addEventListener('input', function () {
    const query = this.value;

    // Limpa o timeout anterior sempre que o usuário continuar digitando
    clearTimeout(searchTimeout);

    if (query.length < 2) {
        document.getElementById('dropdownResultEstoque').style.display = 'none';
        return;
    }

    const params = new URLSearchParams({
        action: 'dropdown-produtos',
        search: `${query}`
    })

    // Inicia um novo timeout que vai esperar 300ms antes de fazer a requisição
    searchTimeout = setTimeout(() => {
        fetch(`../../src/index.php?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                const dropdown = document.getElementById('dropdownResultEstoque');
                dropdown.innerHTML = ''; // Limpa os resultados anteriores

                if (data.length === 0) {
                    dropdown.style.display = 'none';
                    return;
                }

                const results = data.slice(0, 10); // Limitar a 10 resultados
                results.forEach(product => {
                    const div = document.createElement('div');
                    div.textContent = `${product.codigo} - ${product.name}`;
                    div.addEventListener('click', function () {
                        document.getElementById('search-input').value = `${product.codigo} - ${product.name}`;
                        idProduto = `${product.id}`; // Guarda o id do produto na variável definida anteriormente.
                        dropdown.style.display = 'none';

                        buscarLancamentosEstoque(); // Chama a função para buscar lançamentos
                    });

                    dropdown.appendChild(div); // Adiciona o produto ao dropdown
                });

                dropdown.style.display = 'block'; // Mostra o dropdown com os resultados
            })
            .catch(error => {
                console.error('Erro ao buscar produtos:', error);
            });
    }, 300); // Delay de 300ms
});


function buscarLancamentosEstoque() {
    if (!idProduto) return; // Se não houver um idProduto, não faz nada.

    const params = new URLSearchParams({
        action: 'buscar-lancamentos',
        id: idProduto
    });

    fetch(`../../src/index.php?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('lancamentosTable').querySelector('tbody');
            tbody.innerHTML = ''; // Limpa os dados anteriores

            if (data.length === 0) {
                document.getElementById('lancamentosTable').style.display = 'none'; // Esconde a tabela se não houver dados
                return;
            }

            // Preenche a tabela com os dados retornados
            data.forEach(lancamento => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${lancamento.date}</td>
                    <td>${lancamento.type}</td>
                    <td>${lancamento.quantity}</td>
                `;
                tbody.appendChild(row);
            });

            document.getElementById('lancamentosTable').style.display = 'table'; // Mostra a tabela
        })
        .catch(error => {
            console.error('Erro ao buscar lançamentos de estoque:', error);
        });
}