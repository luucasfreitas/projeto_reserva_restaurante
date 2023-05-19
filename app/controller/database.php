<?php
// Conexão com o banco
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
