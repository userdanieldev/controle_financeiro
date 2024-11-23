<?php
session_start();
require_once('connect.php');

if (isset($_POST['create_transaction'])) {
    $name = $_POST['txtNome'];
    $category = $_POST['txtCategoria'];
    $date = $_POST['txtData'];
    $type = $_POST['txtTipo'];
    $value = $_POST['txtValor'];
    $month_id = $_POST['month_id'];

    $sql = "INSERT INTO transactions (name, category, date, type, value, month_id) VALUES ('$name', '$category', '$date', '$type', '$value', '$month_id')";

    if (mysqli_query($conn, $sql)) {
        header("Location: historic.php?id=$month_id");
        exit();
    } else {
        echo "Erro ao salvar a transação: " . mysqli_error($conn);
    }
}

if (isset($_POST['edit_transaction'])) {
    $transaction_id = intval($_POST['tarefa_id']); // ID da transação
    $month_id = intval($_POST['month_id']); // ID do mês
    $name = mysqli_real_escape_string($conn, $_POST['txtNome']);
    $category = mysqli_real_escape_string($conn, $_POST['txtCategoria']);
    $date = mysqli_real_escape_string($conn, $_POST['txtData']);
    $type= mysqli_real_escape_string($conn, $_POST['txtTipo']);
    $value = mysqli_real_escape_string($conn, $_POST['txtValor']);


    $sql = "UPDATE transactions SET name = '{$name}', category = '{$category}', date = '{$date}', type = '{$type}', value = '{$value}' WHERE id = '{$transaction_id}'";

    // $sql .= "WHERE id = '{$tarefaId}'";

    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['message'] = "Transação atualizada!";
        $_SESSION['type'] = 'success';
    } else {
        $_SESSION['message'] = "Não foi possível completar a acão!";
        $_SESSION['type'] = 'error';
    }

    header("Location: historic.php?id=$month_id");
    exit;
}
