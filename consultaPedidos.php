<!DOCTYPE html>
<html>
<head>
    <title>Consultar Pedidos</title>
    <link rel="stylesheet" href="pico-1.5.9/css/pico.min.css">
    <style>
        .table-container {
            max-height: 600px;
            overflow-y: scroll;
        }
    </style>
</head>
<body>
    <?php 
    include('conexao.php');
    include('menu.php');

    if($_SESSION['tipo'] != 0) {
        header("Location:index.php");
        exit;
    }
    ?>
    
 <table id="name-table" style="font-size: 25px;">
        <thead>
            <tr>
                <td>Número Comanda</td>
                <td>Horário Chegada</td>
                <td>Pedido</td>
                <td>Confirmar Saída</td>
            </tr>
        </thead>
        <tbody>
            <?php

            $query = "SELECT * FROM itenspedido WHERE categoria = '3'";
            $result = $conn->query($query);
            
            if ($result) {
                $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                
                foreach ($options as $option) {
                    
                    $horario = isset($option['horarioEntrada']) ? $option['horarioEntrada'] : '--:--';
                    $nome = isset($option['nome']) ? $option['nome'] : 'Item sem nome';
                    $numero = isset($option['numero']) ? $option['numero'] : '0';

                    echo "<tr>";
                    echo "<td>" . $numero . "</td>";
                    echo "<td>" . $horario . "</td>";
                    echo "<td>" . $nome . "</td>";
                    echo "<td><button>Abrir Comanda</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhum pedido encontrado ou erro na consulta.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>