<?php 
include('conexao.php');

$id = $_GET['id'];
$quant = $_POST['quantidade'];
$idPedido = $_POST['idPedido'];

echo $id, $quant;

date_default_timezone_set('America/Argentina/Buenos_Aires');

$query = "SELECT * FROM itenspedido WHERE produto_id = '$id'";
$result = $conn->query($query);
$options = mysqli_fetch_assoc($result); 

if ($result->num_rows > 0) {

    $atual = $options['pago'] + $quant;

    $sql = "UPDATE itenspedido SET pago = {$atual} WHERE produto_id = {$id}";

    if ($conn->query($sql) === TRUE) {
        echo "<script> alert('Produto pago'); window.location.replace('comanda.php?id={$idPedido}')</script> ";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "No results found for pedido_id: " . $id;
}
?>
