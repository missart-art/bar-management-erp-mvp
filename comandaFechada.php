<?php
include('conexao.php');
include('menu.php');

if (isset($_GET['id'])) {
  $_SESSION['id'] = $_GET['id']; // Store the id value in a session variable
}

$id = $_SESSION['id']; // Retrieve the id value from the session

$queryProdutos = "SELECT * FROM produtos";
$resultProdutos = $conn->query($queryProdutos);
$optionsProdutos = mysqli_fetch_all($resultProdutos, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Comanda</title>
  <script>
    function calcularTotal() {

      if (box.checked == true) {
        total = total + (total / 10);
      }

      document.getElementById('valorTotal').innerText = 'R$ ' + total.toFixed(2);
    }
  </script>
</head>
<body onchange="calcularTotal()" onload="zoom()">

  

  <?php
  $queryNome = "SELECT * FROM pedidos WHERE pedido_id = '$id'";
  $resultNome = $conn->query($queryNome);
  $optionsNome = mysqli_fetch_all($resultNome, MYSQLI_ASSOC); 
  foreach ($optionsNome as $optionNome) {
    echo "<h4>Comanda de ", $optionNome['nome'], ", Número ", $optionNome['pedido_id'], "</h4>";
  }
  ?>
  

  <?php
  $query = "SELECT PR.produto_id, PR.nome, PR.preco, SUM(IP.quantidade) totalQuant, SUM(IP.pago) totalPago FROM itenspedido IP JOIN pedidos P ON (IP.pedido_id = P.pedido_id) JOIN produtos PR ON (IP.produto_id = PR.produto_id) WHERE P.pedido_id = {$id} GROUP BY PR.produto_id, PR.nome, PR.preco;"; 
  $result = $conn->query($query);
  $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
  ?>
<?php $queryNome = "SELECT * FROM pedidos WHERE pedido_id = {$id}"; $resultNome = $conn->query($queryNome); $optionsNome = mysqli_fetch_all($resultNome, MYSQLI_ASSOC); foreach($optionsNome as $optionNome){ if($optionNome['gorjeta'] == 1){echo "<h3>Pagou Gorjeta</h3>";}}?>
  <h4>Produtos Comprados</h4>
  <table id="myTable">
    <tr>
      <td>Produto</td>
      <td>Quantidade</td>
      <td>Valor Total</td>
      <td></td>
    </tr>

    <?php

    $total = 0;
    foreach ($options as $option) {
      $falta = $option['totalQuant'] - $option['totalPago'];
      $totalProduto = $option['totalQuant'] * $option['preco'];
    
      $total += (float)$totalProduto;

      if ($falta > 0) {
        echo "<div id='print-section'>";
        echo "<tr>";
        echo "<td>{$option['nome']}</td>";
        echo "<td>{$option['totalQuant']}</td>";
        echo "<td>R$", $totalProduto, "</td>";
        
        echo "<td>";
        echo "<input type='hidden' value={$id} name='idPedido'>";
     
        echo "</td>";
        //echo "<td>";
        //echo "<a href='apagarProduto.php?id={$option['produto_id']}'><button>Apagar Produto</button></a>";
        //echo "</td>";
        echo "</tr>";
        echo "</div>";
      }
    }
    ?>
  </table>

  <!--<input type="checkbox" id="acrescimo" onchange="calcularTotal()">Acréscimo de 10% -->

  <h3>Total: R$<span id="valorTotal"><?php foreach($optionsNome as $optionNome){if($optionNome['gorjeta'] == 1){echo $total + $total/10;}else{echo $total;}} ?></span></h3>
  
  <br/>

  <!-- <button onclick='printSection()'>Imprimir Comanda</button> -->
  <a href="consultaFechadas.php"><button>Confirmar</button></a>


  <script>
    const nameFilterInput = document.getElementById('name-filter-input');
    const nameTable = document.getElementById('name-table');

    nameFilterInput.addEventListener('input', function() {
      const filterValue = nameFilterInput.value.toLowerCase();
      const rows = nameTable.getElementsByTagName('tr');

      for (let i = 1; i < rows.length; i++) {
        const cell = rows[i].getElementsByTagName('td')[0]; // Accessing the first column

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
    function printSection() {
      // Create a new window or iframe for printing
      var printWindow = window.open('', '_blank');
      
      // Get the HTML content of the section to be printed
      var sectionContent = document.getElementById('print-section').innerHTML;
      
      // Set the print window content with the section content
      printWindow.document.write('<html><head><title>Print Section</title></head><body>' + sectionContent + '</body></html>');
      
      // Wait for the content to be loaded before printing
      printWindow.document.addEventListener('DOMContentLoaded', function() {
        printWindow.focus(); // Focus on the print window
        printWindow.print(); // Initiate the print action
        printWindow.close(); // Close the print window after printing is done
      });
    }
  </script>

</body>
</html>
