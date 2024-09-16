let modal, fade;

async function lancarEstoque(event) {
    event.preventDefault();
    const form = document.querySelector('#lcto-estoque');

    try {
        const formData = new FormData(form);
        formData.append('action', 'lancar-estoque');
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

    // Adiciona os event listeners para os botões de abrir e fechar o modal
    const openModalButton = document.querySelector("#open-modal");
    const closeModalButton = document.querySelector("#close-modal");

    if (openModalButton) {
        openModalButton.addEventListener("click", (event) => toggleModal(event));
    }
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
