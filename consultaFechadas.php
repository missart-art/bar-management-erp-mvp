<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="pico-1.5.9/css/pico.min.css">
    <style>
        .table-container {
            max-height: 600px; /* Set your desired height */
            overflow-y: scroll; /* Enable vertical scrolling */
        }
    </style>
</head>
<body>
    <?php 
        include('conexao.php');
        include('menu.php');

        if($_SESSION['tipo'] != 0) {
            header("Location:index.php");
        }
    ?>

    <h2>Comandas Fechadas</h2>

    <?php
        $selectedDate = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');

        if (isset($_POST['date'])) {
            $firstDate = $_POST['date'];
            $secondDate = date('Y-m-d', strtotime($firstDate . ' +1 day'));
            $queryTotal = "SELECT * FROM itenspedido IP JOIN pedidos P ON (IP.pedido_id = P.pedido_id) JOIN produtos PR ON (IP.produto_id = PR.produto_id) WHERE ativo = 0 AND (data = '$firstDate' AND horarioSaida >= '20:00:00')
            OR (data > '$firstDate' AND data < '$secondDate')
            OR (data = '$secondDate' AND horarioSaida < '08:00:00');"; 
        } else {
            $queryTotal = "SELECT * FROM itenspedido IP JOIN pedidos P ON (IP.pedido_id = P.pedido_id) JOIN produtos PR ON (IP.produto_id = PR.produto_id) WHERE ativo = 0"; 
        }

        $resultTotal = $conn->query($queryTotal);
        $optionsTotal = mysqli_fetch_all($resultTotal, MYSQLI_ASSOC);

        $totalProduto = 0;
        $total = 0;

        foreach ($optionsTotal as $optionTotal) {
            $totalProduto = $optionTotal['quantidade'] * $optionTotal['preco'];
    
            if ($optionTotal['gorjeta'] == 1) {
                $totalProduto += $totalProduto / 10;
            }
    
            $total += (float)$totalProduto;
        }

        //echo "<h4>Total do dia: R$ ",$total,"</h4>";
    ?>

    <form method="POST">
        <label for="date">Pesquisar por data:</label>
        <input type="date" name="date" id="date-input">
        <input type="submit" value="Pesquisar">
    </form>
    <a href="vaievolta.php"><button id="voltar">Todas as datas</button></a>

    <br>

    Pesquisar Número/Nome do Cliente: <input type="text" name="dado" id="name-filter-input">
    
    <div class="table-container">
        <table id="name-table" style="font-size: 25px; overflow-y: auto;">

            <thead>
                <tr>
                    <td>Número Comanda</td>
                    <td>Nome Cliente</td>
                    <td>Data</td>
                    <td>Horário Chegada</td>
                    <td>Horário Saída</td>
                    <td>Comanda</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($_POST['date'])) {
                        $firstDate = $_POST['date'];
                        $secondDate = date('Y-m-d', strtotime($firstDate . ' +1 day'));

                        $query = "SELECT * FROM pedidos WHERE (data = '$firstDate' AND horarioSaida >= '00:00:00')
                        OR (data > '$firstDate' AND data < '$secondDate')
                        OR (data = '$secondDate' AND horarioSaida < '23:59:59')";
                    } else {
                        $query = "SELECT * FROM pedidos WHERE data = '$selectedDate'";
                    }

                    $result = $conn->query($query);
                    $options = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    foreach ($options as $option) {
                        if ($option['ativo'] == '0') {
                            $horario = $option['horarioSaida'];

                            if ($horario == "00:00:00") {
                                $horario = "--:--:--";
                            }

                            $date = $option['data'];
                            $formattedDate = date("d/m/y", strtotime($date));

                            echo "<tr><td>", $option['numero'], "</td><td>", $option['nome'], "</td><td>",$formattedDate,"</td><td>", $option['horarioEntrada'], "</td><td>", $horario, "</td><td><a href='comanda.php?id=",$option['cliente_id'],"'><a href='comandaFechada.php?id={$option['pedido_id']}'><button>Abrir Comanda</button></a></td></tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        const nameFilterInput = document.getElementById('name-filter-input');
        const nameTable = document.getElementById('name-table');
        const dateInput = document.getElementById('date-input');

        nameFilterInput.addEventListener('input', function() {
            const filterValue = nameFilterInput.value.toLowerCase();
            const rows = nameTable.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const numberCell = rows[i].getElementsByTagName('td')[0];
                const nameCell = rows[i].getElementsByTagName('td')[1];

                const numberValue = numberCell.textContent.toLowerCase();
                const nameValue = nameCell.textContent.toLowerCase();

                if (numberValue.includes(filterValue) || nameValue.includes(filterValue)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    </script>
</body>
</html>
