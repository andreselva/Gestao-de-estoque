function goToProducts(event) {
    event.preventDefault();
    window.location.href = '../produtos/produtos.php';
}

function goToStock(event) {
    event.preventDefault();
    window.location.href = '../suprimentos/estoque.php';
}

function goToEntryNotes(event) {
    event.preventDefault();
    window.location.href = '../notafiscal/form-nota-entrada.php';
}

function toggleStockMenu(event) {
    const menu = event.currentTarget.nextElementSibling; // Seleciona o submenu
    const isVisible = menu.classList.contains('show'); // Verifica se o submenu está visível

    if (isVisible) {
        menu.style.height = '0'; // Define a altura para zero
        menu.style.opacity = '0'; // Torna invisível
    } else {
        menu.style.height = `${menu.scrollHeight}px`; // Define a altura para a altura do conteúdo
        menu.style.opacity = '1'; // Torna visível
    }

    menu.classList.toggle('show'); // Alterna a classe 'show'
}
