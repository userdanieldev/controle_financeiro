const openModalButton = document.getElementById("openModalButton");
const closeModalButton = document.getElementById("closeModalButton");
const modal = document.getElementById("modal");
const modalContent = document.getElementById("modalContent");

// Mostrar o modal
openModalButton.addEventListener("click", () => {
    modal.classList.remove("hidden");
});

// Fechar o modal ao clicar no "X"
closeModalButton.addEventListener("click", () => {
    modal.classList.add("hidden");
});

// Fechar o modal ao clicar fora do conteúdo do modal
modal.addEventListener("click", (event) => {
    if (!modalContent.contains(event.target)) {
        modal.classList.add("hidden");
    }
});

// MASCARA PARA VALORES
function formatMoney(input) {
    // Remove caracteres não numéricos
    let value = input.value.replace(/\D/g, '');

    // Divide o valor por 100 para ter centavos
    let formattedValue = (value / 100).toFixed(2);

    // Substitui o ponto por vírgula
    formattedValue = formattedValue.replace('.', ',');

    // Adiciona separadores de milhares
    formattedValue = formattedValue.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");

    // Adiciona o "R$" na frente
    input.value = formattedValue ? `R$ ${formattedValue}` : '';
}

