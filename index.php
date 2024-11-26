<?php
session_start();
require_once('connect.php');

if (isset($_POST['add_month'])) {
    $month = $_POST['month'];

    $month_date = date('Y-m-01', strtotime($month));

    $sqlCheck = "SELECT * FROM month WHERE month_date = '$month_date'";
    $resultCheck = mysqli_query($conn, $sqlCheck);

    if (mysqli_num_rows($resultCheck) == 0) {
        $sql = "INSERT INTO month (month_date) VALUES ('$month_date')";
        
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
            exit();
        } else {
            echo "Erro ao inserir o mês: " . mysqli_error($conn);
        }
    } else {
        echo "Este mês já foi cadastrado.";
    }
}

$sql = "SELECT * FROM month";
$result = mysqli_query($conn, $sql);

$totalIncome = 0;
$totalExpense = 0;
$months = [];

if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $month_id = $row['id'];

        $transaction_sql = "
            SELECT 
                SUM(CASE WHEN type = 'Entrada' THEN value ELSE 0 END) AS total_income,
                SUM(CASE WHEN type = 'Saida' THEN value ELSE 0 END) AS total_expense
            FROM transactions
            WHERE month_id = $month_id
        ";

        $transaction_result = mysqli_query($conn, $transaction_sql);

        if ($transaction_result && $transaction_row = mysqli_fetch_assoc($transaction_result)) {
            $totalIncomeForMonth = $transaction_row['total_income'] ?? 0;
            $totalExpenseForMonth = $transaction_row['total_expense'] ?? 0;

            $balance = $totalIncomeForMonth - $totalExpenseForMonth;

            $months[] = [
                'id' => $row['id'],
                'month_date' => $row['month_date'],
                'expense' => $totalExpenseForMonth,
                'income' => $totalIncomeForMonth,
                'balance' => $balance,
            ];

            $totalIncome += $totalIncomeForMonth;
            $totalExpense += $totalExpenseForMonth;
        }
    }

    $finalBalance = $totalIncome - $totalExpense;
} else {
    echo "0 resultados";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Financeiro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        #openModalButton {
            background-color: #32CD32;
            color: #ffffff;
            border: 2px solid #28a745;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        #openModalButton:hover {
            background-color: #28a745;
            transform: scale(1.05);
        }

        .card-hover-effect {
            transition: all 0.3s ease-in-out;
            border: 2px solid transparent;
            border-radius: 10px;
        }

        .card-hover-effect:hover {
            border: 2px solid #32CD32;
            transform: scale(1.03);
            background-color: #333333;
        }

        footer .footer-divider {
            border-top: 1px solid #444;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="bg-dark text-white">

    <!-- Modal de Adicionar Mês -->
    <div class="modal fade" id="addMonthModal" tabindex="-1" aria-labelledby="addMonthModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMonthModalLabel">Adicionar Mês</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="month" class="form-label">Selecione o Mês:</label>
                            <input type="month" class="form-control" id="month" name="month" required>
                        </div>
                        <button type="submit" name="add_month" class="btn btn-primary">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto p-4 space-y-4">

        <h1 class="text-4xl font-bold mb-8 text-center text-teal-400">Relatório Financeiro Anual</h1>

        <!-- Resumo Anual -->
        <div class="mb-8 border rounded-xl shadow-lg bg-gray-800">
            <div class="border-b p-4">
                <h2 class="font-bold text-xl text-teal-300">Resumo Anual</h2>
            </div>
            <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Total Ganho -->
                <div class="flex items-center justify-between p-4 bg-success rounded-lg transition-all duration-300 hover:scale-105">
                    <div>
                        <p class="text-sm font-medium text-white">Total Ganho</p>
                        <p class="text-2xl font-bold text-white">
                            R$ <?= number_format($totalIncome, 2, ',', '.') ?>
                        </p>
                    </div>
                </div>
                <!-- Total Gasto -->
                <div class="flex items-center justify-between p-4 bg-danger rounded-lg transition-all duration-300 hover:scale-105">
                    <div>
                        <p class="text-sm font-medium text-white">Total Gasto</p>
                        <p class="text-2xl font-bold text-white">
                            R$ <?= number_format($totalExpense, 2, ',', '.') ?>
                        </p>
                    </div>
                </div>
                <!-- Saldo Final -->
                <div class="flex items-center justify-between p-4 bg-primary rounded-lg transition-all duration-300 hover:scale-105">
                    <div>
                        <p class="text-sm font-medium text-white">Saldo Final</p>
                        <p class="text-2xl font-bold text-white">
                            R$ <?= number_format($finalBalance, 2, ',', '.') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Meses -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($months as $mes): ?>
            <div class="card-hover-effect bg-dark text-white rounded-xl shadow-lg p-4" onclick="window.location.href='historic.php?id=<?= $mes['id'] ?>'">
                <div class="border-b p-4 flex justify-between items-center">
                    <span class="text-lg font-bold text-teal-300"><?= date('F', strtotime($mes['month_date'])) ?></span>
                    <span class="text-sm text-gray-400">#<?= $mes['id'] ?></span>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500">Gasto:</p>
                            <p class="font-semibold text-danger">R$ <?= number_format($mes['expense'], 2, ',', '.') ?></p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500">Ganho:</p>
                            <p class="font-semibold text-success">R$ <?= number_format($mes['income'], 2, ',', '.') ?></p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500">Saldo:</p>
                            <p class="font-semibold text-blue-500">R$ <?= number_format($mes['balance'], 2, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
                <!-- Botão de exclusão no canto inferior esquerdo -->
                <!-- <div class="mt-4 text-left">
                    <a onclick="return confirm('Tem certeza que deseja excluir?')" href="delete_month.php?id=<?= $mes['id'] ?>" class="text-red-500 hover:text-red-700">Excluir</a>
                </div> -->
                    <a onclick="return confirm('Tem certeza que deseja excluir?')" href="delete_month.php?id=<?= $mes['id'] ?>" class="btn btn-outline-danger btn-sm">Excluir</i></a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Botão de Cadastrar Mês -->
        <div class="text-center mt-8">
            <button id="openModalButton" data-bs-toggle="modal" data-bs-target="#addMonthModal">Cadastrar Mês</button>
        </div>

    </div>

    <!-- Modal de Exclusão -->
    <div class="modal fade" id="deleteMonthModal" tabindex="-1" aria-labelledby="deleteMonthModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMonthModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza de que deseja excluir este mês e todas as transações associadas?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="delete_month.php?id=<?= $mes['id'] ?>" class="btn btn-danger">Confirmar Exclusão</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
    <footer>
            <hr class="my-4 text-secondary">
            <div class="text-center mb-3">
                <a href="#" class="text-primary me-3"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-info me-3"><i class="bi bi-twitter"></i></a>
                <a href="#" style="color: #dd2a7b;" class="me-3"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-info me-3"><i class="bi bi-linkedin"></i></a>
            </div>

            <div class="text-center">
                <p class="mb-0">&copy; <?= date('Y') ?> POBRETÃO - Todos os direitos reservados.</p>
                <p class="mb-0">Desenvolvido por <a href="#" class="text-white text-decoration-none">Daniel Costa e Gustavo Henrique</a></p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
