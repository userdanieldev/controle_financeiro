<?php
session_start();
require_once('connect.php');

// Verificar o ID do mês
if (isset($_GET['id'])) {
    $month_id = intval($_GET['id']);
    // Mapear o número do mês para o intervalo de datas
    $year = date('Y'); // Pega o ano atual
    $month_start = "$year-$month_id-01"; // Primeiro dia do mês
    $month_end = date("Y-m-t", strtotime($month_start)); // Último dia do mês
} else {
    echo "ID do mês não especificado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Transação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Definir limites para o campo de data
            const startDate = "<?= $month_start ?>"; // Data inicial
            const endDate = "<?= $month_end ?>"; // Data final
            const dateField = document.getElementById("txtData"); // Campo de data
            const form = document.querySelector("form"); // Formulário
            const errorMsg = document.getElementById("error-msg"); // Mensagem de erro

            // Configurar os limites no input de data
            dateField.min = startDate;
            dateField.max = endDate;

            // Validar a data no envio do formulário
            form.addEventListener("submit", function (event) {
                const selectedDate = dateField.value;

                // Verificar se a data está dentro do intervalo
                if (selectedDate < startDate || selectedDate > endDate) {
                    event.preventDefault(); // Impede o envio do formulário
                    errorMsg.textContent = `A data deve estar entre ${startDate} e ${endDate}.`;
                } else {
                    errorMsg.textContent = ""; // Limpa a mensagem de erro
                }
            });
        });
    </script>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Criar Transação</h4>
            </div>
            <div class="card-body">
                <form action="acoes.php" method="POST">
                    <input type="hidden" name="month_id" value="<?= $month_id ?>">
                    <div class="mb-4">
                        <label for="txtNome">Nome</label>
                        <input type="text" name="txtNome" id="txtNome" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col mb-4">
                            <label for="txtCategoria">Categoria</label>
                            <input type="text" name="txtCategoria" id="txtCategoria" class="form-control" required>
                        </div>
                        <div class="col mb-4">
                            <label for="txtData">Data</label>
                            <input type="date" name="txtData" id="txtData" class="form-control" required>
                            <small id="error-msg" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="txtTipo">Tipo</label>
                            <select name="txtTipo" id="txtTipo" class="form-control" required>
                                <option value="Entrada">Entrada</option>
                                <option value="Saida">Saída</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="txtValor">Valor</label>
                            <input type="number" name="txtValor" id="txtValor" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" name="create_transaction" class="btn btn-primary mt-3 float-end">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
