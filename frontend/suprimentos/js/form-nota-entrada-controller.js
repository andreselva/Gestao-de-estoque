function goToAddEntryNote(event) {
    event.preventDefault();
    window.location.href = "../suprimentos/form-nota-entrada-incluir.php"
}

document.addEventListener('DOMContentLoaded', function () {
    // Seleciona o elemento do tipo de pessoa (física ou jurídica)
    const pessoaTipo = document.getElementById('pessoaTipo');

    // Seleciona o campo de documento e o label
    const documentField = document.getElementById('documentField');
    const documentLabel = document.getElementById('documentLabel');
    const ieField = document.getElementById('ieField');
    const contribuinteField = document.getElementById('contribuinteField');

    // Evento de mudança no select de tipo de pessoa
    pessoaTipo.addEventListener('change', function () {
        const selectedValue = this.value;

        if (selectedValue === 'p-fisica') {
            // Alterar para CPF
            documentLabel.textContent = 'CPF';
            documentField.setAttribute('placeholder', 'Digite o CPF');
            documentField.setAttribute('maxlength', '14');
            documentField.setAttribute('pattern', '\\d{14}');

            ieField.style.display = 'none';
            contribuinteField.style.display = 'none';

        } else if (selectedValue === 'p-juridica') {
            // Alterar para CNPJ
            documentLabel.textContent = 'CNPJ';
            documentField.setAttribute('placeholder', 'Digite o CNPJ');
            documentField.setAttribute('maxlength', '18');
            documentField.setAttribute('pattern', '\\d{14}');

            ieField.style.removeProperty('display');
            contribuinteField.style.removeProperty('display');
        }
    });
});


document.getElementById('check-outro-endereco').addEventListener('change', function () {
    const enderecoAdicional = document.getElementById('endereco-adicional');
    const enderecoAdicional2 = document.getElementById('endereco-adicional-2');

    // Verifica se o checkbox está marcado
    if (this.checked) {
        enderecoAdicional.style.removeProperty('display');  // Mostra os campos
        enderecoAdicional2.style.removeProperty('display');
    } else {
        enderecoAdicional.style.display = 'none';    // Esconde os campos
        enderecoAdicional2.style.display = 'none';
    }
});
