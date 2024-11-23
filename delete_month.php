<?php
session_start();
require_once('connect.php');

// Verifica se o ID do mês foi passado via URL
if (isset($_GET['id'])) {
    $month_id = $_GET['id'];

    // Excluir todas as transações associadas ao mês
    $deleteTransactions = "DELETE FROM transactions WHERE month_id = $month_id";
    $resultDeleteTransactions = mysqli_query($conn, $deleteTransactions);

    if (!$resultDeleteTransactions) {
        die("Erro ao excluir transações: " . mysqli_error($conn));
    }

    // Excluir o mês
    $deleteMonth = "DELETE FROM month WHERE id = $month_id";
    $resultDeleteMonth = mysqli_query($conn, $deleteMonth);

    if ($resultDeleteMonth) {
        // Redirecionar de volta para a página principal após a exclusão
        header('Location: index.php');
        exit();
    } else {
        echo "Erro ao excluir o mês: " . mysqli_error($conn);
    }
} else {
    echo "ID de mês não encontrado!";
}

?>
