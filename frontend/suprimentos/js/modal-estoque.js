let modal, fade;


async function lancarEstoque(event) {
    event.preventDefault();
    const form = document.querySelector('#lcto-estoque');
    const idProduto = selectedProductId;
    const button = document.getElementById('btn-lcto-estoque');
    const type = document.getElementById('tipo');
    const fields = document.querySelectorAll('#tipo, #custo-lcto, #quantidade, #price')

    if (type.value === '') {
        alert('Selecione o tipo do lançamento.');
        return;
    }

    fields.forEach(field => {
        field.readOnly = true;
        field.style.backgroundColor = '#c2c2c277';  // Altera a cor do campo para indicar que está desabilitado
    });

    button.disabled = true;
    button.style.backgroundColor = '#75b88f';

    try {
        const formData = new FormData(form);
        formData.append('action', 'lancar-estoque');
        formData.append('idProduto', idProduto);
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

        if (responseData.status === 'success') {
            alert("Lançamento efetuado com sucesso!")
            window.location.reload();
        } else {
            alert("Houve um problema no lançamento. O estoque não foi lançado.")
            button.disabled = false;
        }

    } catch (erro) {

    }
}

const toggleModal = (event) => {
    if (event) {
        event.preventDefault();
    }
    modal.classList.toggle("hide");
    fade.classList.toggle("hide");
};

document.addEventListener("DOMContentLoaded", function () {
    modal = document.querySelector("#modal");
    fade = document.querySelector("#fade");

    // Seleciona todos os botões que abrem o modal e adiciona o event listener
    const openModalButtons = document.querySelectorAll(".open-modal");

    openModalButtons.forEach(button => {
        button.addEventListener("click", (event) => {
            event.preventDefault();

            // Captura o id do produto diretamente do atributo data-id do botão
            selectedProductId = button.getAttribute("data-id");

            // Abre o modal
            toggleModal(event);
        });
    });

    const closeModalButton = document.querySelector("#close-modal");
    if (closeModalButton) {
        closeModalButton.addEventListener("click", (event) => toggleModal(event));
    }

    if (fade) {
        fade.addEventListener("click", (event) => toggleModal(event));
    }
});

document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && modal && !modal.classList.contains("hide")) {
        toggleModal();
    }
});



// Configura eventos ao carregar o DOM
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