let modal, fade;

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
