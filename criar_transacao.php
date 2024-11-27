<?php
session_start();
require_once('connect.php');

if (isset($_GET['id'])) {
    $month_id = intval($_GET['id']);
    
    $year = date('Y');
    
    $month_id = str_pad($month_id, 2, '0', STR_PAD_LEFT);
    
    $month_start = "$year-$month_id-01"; 
    
    $month_end = date("Y-m-t", strtotime($month_start)); 
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

        .btn-primary {
            background-color: #007bff; 
            border-color: #007bff; 
        }

        .btn-primary:hover {
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

        .text-danger {
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

        small {
            color: #ff6b6b; 
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
                            <select name="txtCategoria" id="txtCategoria" class="form-control" required>
                            <option class="text-danger" disabled>Categorias de Saída</option>
                                        <option value="Alimentação">Alimentação</option>
                                        <option value="Transporte">Transporte</option>
                                        <option value="Lazer">Lazer</option>
                                        <option value="Saúde">Saúde</option>
                                        <option value="Compras">Compras</option>
                                        <option value="Outros">Educação</option>
                                        <option value="Aplicação em Investimentos">Aplicação em Investimentos</option>
                                        <option value="Serviços">Serviços</option>
                                        <option class="text-success" disabled>Categorias de Entrada </option>
                                        <option value="Renda">Renda</option>
                                        <option value="Renda Extra">Renda Extra</option>
                                        <option value="Rendimento de Investimentos">Rendimento de Investimentos</option>
                                        <option value="Outros">Outros</option>
                            </select>
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
                                <option class="text-success" value="Entrada">Entrada</option>
                                <option class="text-danger" value="Saida">Saída</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="txtValor">Valor</label>
                            <input type="number" name="txtValor" id="txtValor" class="form-control" step="any" required>
                        </div>
                    </div>
                    <button type="submit" name="create_transaction" class="btn btn-primary mt-3 float-end">Salvar</button>
                    <button type="button" class="btn btn-outline-light mt-3 float-start" onclick="window.history.back()">Voltar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
