<?php
include('conexao.php');

$id = $_GET['id'];

$queryNome = "SELECT * FROM pedidos WHERE pedido_id = ?";
$stmt = $conn->prepare($queryNome);
$stmt->bind_param('s', $id);
$stmt->execute();
$resultNome = $stmt->get_result();
$optionsNome = $resultNome->fetch_all(MYSQLI_ASSOC);

$stmt->close();

if (count($optionsNome) > 0) {
    $optionNome = $optionsNome[0];

    $newGorjeta = $optionNome['gorjeta'] == 0 ? 1 : 0;

    $updateQuery = "UPDATE pedidos SET gorjeta = ? WHERE pedido_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('ss', $newGorjeta, $id);
    if ($stmt->execute()) {
        $message = $newGorjeta == 1 ? 'Gorjeta de 10% adicionada na' : 'Gorjeta de 10% retirada da';
        $message .= " comanda de {$optionNome['nome']}";
        echo "<script>alert('$message'); window.location.replace('comanda.php?id={$id}');</script>";
    } else {
        echo "Erro ao atualizar a gorjeta: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Pedido não encontrado.";
}

$conn->close();
?>
