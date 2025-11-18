<?php
include("conexao.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE login = ? AND senha = ?");
    $stmt->bind_param("ss", $login, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['tipo'] = $usuario['tipo'];

        $accessKey = generateAccessKey();

        $_SESSION['access_key'] = $accessKey;
        
        header('Location: index.php');
        exit();
    } else {
        echo "<script>alert('Nome de usuário ou senha incorretos'); window.location.replace('login.php');</script>";
        exit();
    }
    
    $stmt->close();
}

function generateAccessKey() {
    $length = 20;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $accessKey = '';

    for ($i = 0; $i < $length; $i++) {
        $accessKey .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $accessKey;
}
?>