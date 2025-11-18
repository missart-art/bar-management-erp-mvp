<?php
include ('conexao.php');

date_default_timezone_set('America/Argentina/Buenos_Aires');

$id = $_GET['id'];
$hrrSaida = date('H:i:s');

$sql = "UPDATE pedidos SET ativo = '0', horarioSaida = '$hrrSaida' WHERE pedido_id = '$id'";

if ($conn->query($sql) === TRUE) {
    $queryNome = "SELECT nome, numero FROM pedidos WHERE pedido_id = '$id'";
    $resultNome = $conn->query($queryNome);
    $optionsNome = mysqli_fetch_all($resultNome, MYSQLI_ASSOC); 
    foreach ($optionsNome as $optionNome){
        echo "<script> alert('Comanda de " . $optionNome['nome'] . ", Número " . $optionNome['numero'] . " Paga'); window.location.replace('consulta.php');</script>";
    }
} else {
    echo "Error updating record: " . $conn->error;
}
?>
