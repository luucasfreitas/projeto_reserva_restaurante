<?php
require_once 'database.php';
$nome_cliente = $_POST['nome_cliente'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$data = $_POST['data'];
$hora_entrada = $_POST['hora_entrada'];
$hora_saida = $_POST['hora_saida'];
$quantidade = $_POST['quantidade'];
$obs = $_POST['obs'];

$sql_insert_reserva = "INSERT INTO sistema_reserva_restaurante.reservas (nome_cliente, telefone, email, data, hora_entrada, hora_saida, mesas, obs) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert_reserva);

$stmt->bind_param("ssssssis", $nome_cliente, $telefone, $email, $data, $hora_entrada, $hora_saida, $quantidade, $obs);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Reserva concluída.";
} else {
    echo "Falha ao inserir os dados.";
}
?>