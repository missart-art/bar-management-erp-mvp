<?php
include('conexao.php');
$pedido_id = $_SESSION['id'];
$quant = $_POST['quant'];
$produto_id = $_GET['id'];

$sql = "INSERT INTO itenspedido (pedido_id, produto_id, quantidade, pago) VALUES ('$pedido_id', '$produto_id', '$quant', '0')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Produto adicionado na comanda com sucesso');window.location.replace('comanda.php?id={$pedido_id}');</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
