<?php
$host = "localhost";
$username = "root";
$password = '';
$dbname = 'pobretao';

// Conexão com o banco de dados
$conn = mysqli_connect($host, $username, $password, $dbname);

// Verificação da conexão
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}