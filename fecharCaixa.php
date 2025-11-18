<?php

include('conexao.php');

$sql = "UPDATE pedidos SET fechado = '1', ativo = '0' WHERE fechado = '0'";

if (mysqli_query($conn, $sql)) {
  echo "<script>alert('Caixa Fechado com Sucesso!'); window.location.replace('consulta.php');</script>";
} else {
  echo "Erro ao fechar o caixa: " . mysqli_error($conn);
}

mysqli_close($conexao);

?>
