<?php
include('conexao.php');

// Recuperar dados do formulário
$nome = $_POST['name'];
$categoria = $_POST['category'];
$preco = $_POST['price'];
$valorCompra = $_POST['valorCompra'];

// Prepare the query using a parameterized statement
$query = "SELECT * FROM produtos WHERE nome = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $nome);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Produto já existe');window.location.replace('cadastroProduto.php')</script>";
} else {
    // Prepare the insert statement using a parameterized query
    $sql = "INSERT INTO produtos (nome, categoria, preco, valorCompra) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdd", $nome, $categoria, $preco, $valorCompra);
    $stmt->execute();

    echo "<script>alert('Produto adicionado com sucesso.');window.location.replace('cadastroProduto.php')</script>";
    exit();
}

// Close the database connection
$stmt->close();
$conn->close();
?>