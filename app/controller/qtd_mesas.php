<?php
require_once 'database.php';
$data = $_POST['data'];
$hora_entrada = $_POST['hora_entrada'];
$hora_saida = $_POST['hora_saida'];

$sql = "SELECT * FROM reservas WHERE data = ? AND hora_entrada = ? AND hora_saida = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $data, $hora_entrada, $hora_saida);
$stmt->execute();
$result = $stmt->get_result();
$cont_mesas = 15;
$num_registros = $result->num_rows;

$cont_mesas = 15;

while ($row = $result->fetch_assoc()) {
    $valorColuna = $row['mesas']; // Substitua 'nome_da_coluna' pelo nome real da coluna que deseja somar
    $cont_mesas -= $valorColuna;
}
if($cont_mesas < 1){
    echo '0';
} else {
    echo $cont_mesas;
}


$stmt->close();
$conn->close();