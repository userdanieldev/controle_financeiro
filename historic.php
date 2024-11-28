<?php
session_start();
require_once('connect.php');

if (isset($_GET['id'])) {
    $month_id = intval($_GET['id']);

    $sql = "SELECT * FROM transactions WHERE month_id = $month_id";
    $result = mysqli_query($conn, $sql);

    $totalIncome = 0;
    $totalExpense = 0;
    $finalBalance = 0;

    $transactions = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $transactions[] = $row;

            if ($row['type'] === 'Entrada') {
                $totalIncome += $row['value'];
            } elseif ($row['type'] === 'Saida') {
                $totalExpense += $row['value'];
            }
        }
        $finalBalance = $totalIncome - $totalExpense;
    }
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
    <title>Histórico de Transações</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-dark text-white">
    <div class="container p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-white">Histórico de Transações</h1>
            <div>
                <a href="index.php" class="btn btn-md mb-3 btn-secondary me-2">Voltar ao Resumo Anual</a>
                <a href="criar_transacao.php?id=<?= $month_id ?>" id="openModalButton" class="btn btn-md mb-3 btn-primary">
                    Cadastrar Transação
                </a>
            </div>
        </div>

        <div class="mb-8 border rounded-xl shadow-lg bg-gray-800">
            <div class="border-bottom p-4">
                <h2 class="font-bold">Resumo Mensal</h2>
            </div>
            <div class="p-4 row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="p-3 bg-success text-white rounded-lg shadow-sm transition-all duration-300 hover:scale-105">
                        <p class="h5">Total Ganho</p>
                        <p class="h3">R$ <?= number_format($totalIncome, 2, ',', '.') ?></p>
                    </div>
                </div>
                <div class="col">
                    <div class="p-3 bg-danger text-white rounded-lg shadow-sm transition-all duration-300 hover:scale-105">
                        <p class="h5">Total Gasto</p>
                        <p class="h3">R$ <?= number_format($totalExpense, 2, ',', '.') ?></p>
                    </div>
                </div>
                <div class="col">
                    <div class="p-3 bg-primary text-white rounded-lg shadow-sm transition-all duration-300 hover:scale-105">
                        <p class="h5">Saldo Final</p>
                        <p class="h3">R$ <?= number_format($finalBalance, 2, ',', '.') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive bg-secondary rounded-xl mt-4 shadow-lg">
            <div class="p-4">
                <table class="table text-white">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome / Descrição</th>
                            <th>Categoria</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transactions)): ?>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr>
                                    <td><?= $transaction['id']; ?></td>
                                    <td><?= $transaction['name']; ?></td>
                                    <td><?= $transaction['category']; ?></td>
                                    <td>
                                        <span class="badge <?= $transaction['type'] === 'Entrada' ? 'bg-success' : 'bg-danger'; ?>">
                                            <?= strtoupper($transaction['type']); ?>
                                        </span>
                                    </td>
                                    <td>R$ <?= number_format($transaction['value'], 2, ',', '.'); ?></td>
                                    <td><?= date('d/m/Y', strtotime($transaction['date'])); ?></td>
                                    <td>
                                    <a href="#editModal_<?= $transaction['id'] ?>" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal">
                                        Editar
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal_<?= $transaction['id'] ?>">
                                        Excluir
                                    </button>
                                    </td>
                                    <!-- Modal do Editar Transação -->
                                    <div class="modal fade" id="editModal_<?= $transaction['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-dark">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5 text-light" id="exampleModalLabel">Confirmação</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-light">
                                                    Prosseguir com a edição?
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="editar_transacao.php?id=<?= $transaction['id']?>" id="confirmEditButton" class="btn btn-outline-success"><i class="bi bi-check-circle-fill"></i></a>
                                                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal do Excluir Transação -->
                                <div class="modal fade" id="deleteModal_<?= $transaction['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel_<?= $transaction['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-dark">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5 text-light" id="deleteModalLabel_<?= $transaction['id'] ?>">Confirmação</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-light">
                                                Prosseguir com a exclusão?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="acoes.php" method="POST">
                                                    <input type="hidden" name="delete_transaction" value="<?= $transaction['id'] ?>">
                                                    <button type="submit" class="btn btn-outline-success"><i class="bi bi-check-circle-fill"></i></button>
                                                </form>
                                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Nenhuma transação encontrada para este mês.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
