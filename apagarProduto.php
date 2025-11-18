<?php 
include('conexao.php');

$id = $_SESSION['id'];
$idProduto = $_GET['id'];

$sql = "UPDATE itenspedido SET quantidade = 0 WHERE produto_id = {$idProduto} AND pedido_id = {$id}";

if ($conn->query($sql)) {
  echo "<script>alert('Produto Apagado');window.location.replace('comanda.php?id={$id}')</script>";
} else {
  echo "Error updating quantity: " . $conn->error;
}

$conn->close();
?>
