<?php
include('conexao.php');
include('menu.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro Reserva</title>

    <script src="criarComanda.js"></script>
    <script type="text/javascript">
        function zoom() {
            document.body.style.zoom = "80%" 
        }
    </script>

    <link rel="stylesheet" href="pico-1.5.9/css/pico.min.css">

    <style>
        @media only screen and (prefers-color-scheme: light) {
            :root:not([data-theme]) {
                --primary: #8e24aa;
                --primary-hover: #9c27b0;
                --primary-focus: rgba(142, 36, 170, 0.25);
                --primary-inverse: #FFF;
            }
        }
    </style>

</head>
<body style="font-size: 25px;">
   
    <h3>Criar nova Comanda</h3>
    <form action="criarComanda.php" method="POST">
        <table>
            <tr>
                <td>Nome:</td>
                <td><input type="text" name="nome"></td>
                <td><input type="submit" value="Nova Comanda"></td>
            </tr>
        </table>
    </form>

    <br><br>

    <DIV STYLE="background-color:#555555; height:5px; width:100%; opacity:50%"></DIV>

    <?php

    if($_SESSION['tipo'] == 0){
        echo "<table><tr>";
        echo "<td>";
        echo "<span onclick=\"return confirm('Fechar caixa?');\"><a href='fecharCaixa.php' onclick='return false;'><a href='fecharCaixa.php'><button>Fechar Caixa</button></a></span>";
        echo "</td>";
        echo "</tr></table>";
        
      }else{
        echo "<table><tr>";
        echo "<td>";
        echo "<span onclick=\"return confirm('Fechar caixa?');\"><a href='fecharCaixa.php' onclick='return false;'><button disabled>Fechar Caixa</button></a></span>";
        echo "</td>";
        echo "</tr></table>";
      }
      ?>

    
<h3>Procurar Comanda</h3>
    
        Pesquisar Número/Nome do Cliente:<input type="text" name="dado" id="name-filter-input">
      
    

    <br>
 
    <table id="name-table" style="font-size: 25px;">
        <thead>
            <tr>
                <td>Número Comanda</td>
                <td>Nome Cliente</td>
                <td>Horário Chegada</td>
                <td>Horário Saída</td>
                <td>Comanda</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM pedidos";
            $result = $conn->query($query);
            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $i = 0;

            foreach ($options as $option) {
               
                   
                    if($option['ativo'] == '1'){
                        $horario = $option['horarioSaida'];

                if($horario == "00:00:00"){

                    $horario = "--:--:--";

                }
             echo "<tr><td>", $option['numero'], "</td><td>", $option['nome'], "</td><td>", $option['horarioEntrada'], "</td><td>", $horario, "</td><td><a href='comanda.php?id=",$option['pedido_id'],"'><button>Abrir Comanda</button></a></td></tr>";
             };
            };
          
            ?>
        </tbody>
    </table>

   <script>
    const nameFilterInput = document.getElementById('name-filter-input');
    const nameTable = document.getElementById('name-table');

    nameFilterInput.addEventListener('input', function() {
        const filterValue = nameFilterInput.value.toLowerCase();
        const rows = nameTable.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const column = Number.isNaN(Number(filterValue)) ? 1 : 0; // Check if filterValue is a number

            const cell = rows[i].getElementsByTagName('td')[column];

            if (cell) {
                const value = cell.textContent.toLowerCase();

                if (value.includes(filterValue)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    });
</script>
</body>
</html>