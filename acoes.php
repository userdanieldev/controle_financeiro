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

    $sql = "INSERT INTO transactions (name, category, date, type, value, month_id) 
            VALUES ('$name', '$category', '$date', '$type', $value, $month_id)";

    if (mysqli_query($conn, $sql)) {
        header("Location: historic.php?id=$month_id");
        exit();
    } else {
        echo "Erro ao salvar a transação: " . mysqli_error($conn);
    }
}
