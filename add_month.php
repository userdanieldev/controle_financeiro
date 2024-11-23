<?php
session_start();
require_once('connect.php');

if (isset($_POST['add_month'])) {
    $month = $_POST['month'];

    // Formatar para o primeiro dia do mês (YYYY-MM-01)
    $month_date = date('Y-m-01', strtotime($month));

    $sqlCheck = "SELECT * FROM month WHERE month_date = '$month_date'";
    $resultCheck = mysqli_query($conn, $sqlCheck);

    if (mysqli_num_rows($resultCheck) == 0) {
        $sql = "INSERT INTO month (month_date) VALUES ('$month_date')";
        
        if (mysqli_query($conn, $sql)) {
            header('Location: ../index.php');
            exit();
        } else {
            echo "Erro ao inserir o mês: " . mysqli_error($conn);
        }
    } else {
        echo "Este mês já foi cadastrado.";
    }
}
?>
