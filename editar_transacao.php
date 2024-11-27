<?php

require_once('connect.php');

if (isset($_GET['id'])) {
    $transaction_id = intval($_GET['id']);
    $sql = "SELECT * FROM transactions WHERE id = $transaction_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $transaction = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='alert alert-danger'>Transação não encontrada.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger'>ID da transação não especificado.</div>";
    exit();
}

$year = date('Y'); 
$month_id = date('m', strtotime($transaction['date'])); 
$month_start = "$year-$month_id-01"; 
$month_end = date("Y-m-t", strtotime($month_start)); 

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Transação</title>
    <style>
        body {
            background-color: #121212; 
            color: #e0e0e0; 
        }

        .card {
            background-color: #1f1f1f; 
            border-color: #333333;
        }

        .card-header {
            background-color: #333333; 
            color: #e0e0e0; 
        }

        .form-control {
            background-color: #2a2a2a; 
            color: #e0e0e0; 
            border: 1px solid #444444; 
        }

        .form-control:focus {
            background-color: #3c3c3c; 
            border-color: #007bff; 
            color: #ffffff; 
        }

        .btn-primary, .btn-secondary {
            background-color: #007bff; 
            border-color: #007bff; 
        }

        .btn-primary:hover, .btn-secondary:hover {
            background-color: #0056b3; 
            border-color: #004085; 
        }

        .btn-secondary {
            background-color: #6c757d; 
            border-color: #6c757d; 
        }

        .btn-secondary:hover {
            background-color: #5a6268; 
            border-color: #545b62; 
        }

        small {
            color: #ff6b6b; 
        }

        select, input[type="number"], input[type="date"] {
            background-color: #2a2a2a;
            border: 1px solid #444444;
            color: #e0e0e0;
        }

        select:focus, input[type="number"]:focus, input[type="date"]:focus {
            background-color: #3c3c3c;
            border-color: #007bff;
            color: #ffffff;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const startDate = "<?= $month_start ?>";
            const endDate = "<?= $month_end ?>"; 
            const dateField = document.getElementById("txtData"); 
            const form = document.querySelector("form"); 
            const errorMsg = document.getElementById("error-msg"); 

            dateField.min = startDate;
            dateField.max = endDate;

            form.addEventListener("submit", function (event) {
                const selectedDate = dateField.value;

                if (selectedDate < startDate || selectedDate > endDate) {
                    event.preventDefault(); 
                    errorMsg.textContent = `A data deve estar entre ${startDate} e ${endDate}.`;
                } else {
                    errorMsg.textContent = ""; 
                }
            });
        });
    </script>
</head>
<body>
    <main>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Editar Transação</h4>
                        </div>
                        <div class="card-body">
                            <form action="acoes.php" method="post">
                                <input type="hidden" name="month_id" value="<?=$transaction['month_id']?>">
                                <input type="hidden" name="tarefa_id" value="<?=$transaction['id']?>">

                                <div class="mb-4">
                                    <label for="txtNome">Nome / Descrição</label>
                                    <input type="text" name="txtNome" id="txtNome" value="<?=$transaction['name']?>" class="form-control">
                                </div>

                                <div class="mb-4">
                                    <label for="txtCategoria">Categoria</label>
                                    <select name="txtCategoria" id="txtCategoria" class="form-control" required>
                                        <option class="text-danger" disabled>Categorias de Saída</option>
                                        <option value="Alimentação" <?= $transaction['category'] == 'Alimentação' ? 'selected' : '' ?>>Alimentação</option>
                                        <option value="Transporte" <?= $transaction['category'] == 'Transporte' ? 'selected' : '' ?>>Transporte</option>
                                        <option value="Lazer" <?= $transaction['category'] == 'Lazer' ? 'selected' : '' ?>>Lazer</option>
                                        <option value="Saúde" <?= $transaction['category'] == 'Saúde' ? 'selected' : '' ?>>Saúde</option>
                                        <option value="Compras" <?= $transaction['category'] == 'Compras' ? 'selected' : '' ?>>Compras</option>
                                        <option value="Outros" <?= $transaction['category'] == 'Outros' ? 'selected' : '' ?>>Educação</option>
                                        <option value="Aplicação em Investimentos" <?= $transaction['category'] == 'Aplicação em Investimentos' ? 'selected' : '' ?>>Aplicação em Investimentos</option>
                                        <option value="Serviços" <?= $transaction['category'] == 'Serviçoss' ? 'selected' : '' ?>>Serviços</option>
                                        <option class="text-success" disabled>Categorias de Entrada </option>
                                        <option value="Renda" <?= $transaction['category'] == 'Renda' ? 'selected' : '' ?>>Renda</option>
                                        <option value="Renda Extra" <?= $transaction['category'] == 'Renda Extra' ? 'selected' : '' ?>>Renda Extra</option>
                                        <option value="Rendimento de Investimentos" <?= $transaction['category'] == 'Rendimento de Investimentos' ? 'selected' : '' ?>>Rendimento de Investimentos</option>
                                        <option value="Outros" <?= $transaction['category'] == 'Outros' ? 'selected' : '' ?>>Outros</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label for="txtTipo">Tipo</label>
                                        <select name="txtTipo" id="txtTipo" class="form-control" required>
                                            <option class="text-success" value="Entrada" <?= $transaction['type'] == 'Entrada' ? 'selected' : '' ?>>Entrada</option>
                                            <option class="text-danger" value="Saida" <?= $transaction['type'] == 'Saida' ? 'selected' : '' ?>>Saída</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="txtData">Data</label>
                                        <input type="date" name="txtData" id="txtData" value="<?=$transaction['date']?>" class="form-control">
                                        <small id="error-msg" class="text-danger"></small>
                                    </div>
                                    <div class="col">
                                        <label for="txtValor">Valor</label>
                                        <input type="number" name="txtValor" id="txtValor" value="<?=$transaction['value']?>" class="form-control" step="any">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <button type="submit" name="edit_transaction" class="btn btn-outline-primary float-end mt-3">Salvar</button>
                                    <button type="button" class="btn btn-outline-light mt-3 float-start" onclick="window.history.back()">Voltar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
