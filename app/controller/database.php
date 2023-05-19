<?php
// Conexão com o banco
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_reserva_restaurante";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
