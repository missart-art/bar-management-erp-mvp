<?php

$servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'snoockers';

        //creating connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
    
session_start(); 

if($_SESSION['tipo'] == ""){
		header("Location:login.php");
}


?>

             

