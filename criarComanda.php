<?php

include('conexao.php');

$query = "SELECT * FROM pedidos";
$result = $conn->query($query);
$options = mysqli_fetch_all($result, MYSQLI_ASSOC);

date_default_timezone_set('America/Argentina/Buenos_Aires');

$name = $_POST['nome'];
$hrrEntrada = date('H:i:s');
$data = date('Y-m-d');
$i = 1;

// Check if the counter variable is already set in the session
if (!isset($_SESSION['counter']) || !isset($_SESSION['last_reset'])) {
    // If not set, initialize the counter and last_reset variables
    $_SESSION['counter'] = 1;
    $_SESSION['last_reset'] = time();
}

// Get the current hour in 24-hour format
$current_hour = date("H");

// Reset the counter if it's 5 PM or later and a day has passed since the last reset
if ($current_hour >= 12 && time() - $_SESSION['last_reset'] >= 24 * 60 * 60) {
    $_SESSION['counter'] = 1; // Reset the counter
    $_SESSION['last_reset'] = time(); // Update the last reset time
}

// Increase the counter by one for every request
$i = $_SESSION['counter']++;

$sql = "INSERT INTO pedidos (nome, data, horarioEntrada, numero, ativo) VALUES ('$name', '$data', '$hrrEntrada','$i', '1')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Comanda de $name feita! Número da comanda: " . $i . "'); location.replace('consulta.php');</script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
