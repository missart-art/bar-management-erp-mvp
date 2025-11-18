User
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

  Pesquisar Nome do Produto:
  <input type='text' name='dado' id='name-filter-input'>
  
  <table id="name-table">
    <tr>
      <td>Produtos</td>
      <td>Preço</td>
      <td>Quantidade</td>
      <td></td>
    </tr>

    <?php
    $selectedProducts = []; // Array to store selected products
    $i = 0;
    foreach ($optionsProdutos as $optionProdutos) {
      if (empty($optionProdutos['nome']) || empty($optionProdutos['preco']) || !$optionProdutos['disponivel']) {
        continue; // Skip the iteration if the product is missing name, price, or not available
      }
      
      $quantName = 'quant' . ++$i;
      echo "<form action='comprarProduto.php?id={$optionProdutos['produto_id']}' method='POST'>";
      echo "<tr>";
      echo "<td>{$optionProdutos['nome']}</td>";
      echo "<td>R$ {$optionProdutos['preco']}</td>";
      echo "<td><input type='number' name='quant' onchange='calcularTotal()' onkeyup='calcularTotal()'></td>";
      echo "<td>'<input type='submit' value='Adicionar'></td>";
      echo "</tr>";
      echo "</form>";

      // Check if quantity is greater than 0 and store the product details
      if (isset($_GET[$quantName]) && $_GET[$quantName] > 0) {
        $selectedProducts[] = [
          'produto' => $option['nome'],
          'quantidade' => $_GET[$quantName]
        ];
      }
    }
    ?>
  </table>

  <?php
  $query = "SELECT PR.produto_id, PR.nome, PR.preco, SUM(IP.quantidade) totalQuant, SUM(IP.pago) totalPago FROM itenspedido IP JOIN pedidos P ON (IP.pedido_id = P.pedido_id) JOIN produtos PR ON (IP.produto_id = PR.produto_id) WHERE P.pedido_id = {$id} GROUP BY PR.produto_id, PR.nome, PR.preco;"; 
  $result = $conn->query($query);
  $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
  ?>

  <h4>Produtos Comprados</h4>
  <table id="myTable">
    <tr>
      <td>Produto</td>
      <td>Quantidade</td>
      <td>Valor Total</td>
      <td>Pagar</td>
      <td></td>
    </tr>

    <?php

    $total = 0;
    foreach ($options as $option) {
      $falta = $option['totalQuant'] - $option['totalPago'];
      $totalProduto = $falta * $option['preco'];
    
      $total += (float)$totalProduto;



      if ($falta > 0) {
        echo "<tr>";
        echo "<td>{$option['nome']}</td>";
        echo "<td>{$falta}</td>";
        echo "<td>R$", $totalProduto, "</td>";
        echo "<td>";
        echo "<form action='pagarProduto.php?id={$option['produto_id']}' method='POST'>";
        if($_SESSION['tipo'] == 0){
        echo "<input type='number' name='quantidade' max={$falta}>";
        echo "</td>";
        echo "<td>";
        echo "<input type='hidden' value={$id} name='idPedido'>";
        echo "<input type='submit' value='Pagar'></td>";
        echo "</form>";
        echo "<td><a href='apagarProduto.php?id={$option['produto_id']}'><button>Apagar</button></td>";
      }else{
        echo "<input type='number' name='quantidade' max={$falta} disabled>";
        echo "</td>";
        echo "<td>";
        echo "<input type='hidden' value={$id} name='idPedido'>";
        echo "<input type='submit' value='Pagar' disabled>";
        echo "</form>";
        echo "<td><button disabled>Apagar</button>";
      }
        echo "</td>";
        //echo "<td>";
        //echo "<a href='apagarProduto.php?id={$option['produto_id']}'><button>Apagar Produto</button></a>";
        //echo "</td>";
        echo "</tr>";
      };
    };
    ?>
  </table>

  


  <!--<input type="checkbox" id="acrescimo" onchange="calcularTotal()">Acréscimo de 10% -->

  <h3>Total: R$ <span id="valorTotal"><?php if($optionNome['gorjeta'] == 0){echo $total;}else{echo $total + $total/10;} ?></span></h3>
  

  <?php if($_SESSION['tipo'] == 0){ if($optionNome['gorjeta'] == 0){

      echo "<form action='modificarGorjeta.php?id={$id}' method='POST'>";
      echo "<input type='submit' value='Adicionar Gorjeta de 10%'>";
      echo "</form>";

  }else{
    echo "<form action='modificarGorjeta.php?id={$id}' method='POST'>";
      echo "<input type='submit' value='Remover Gorjeta de 10%'>";
      echo "</form>";
  };
  ?>

  <br/>
  <?php echo "<span onclick=\"return confirm('Fechar comanda?');\"><a href='fecharComanda.php?id={$id}'><button>Fechar Comanda</button></a></span>";
;}else{echo "<button disabled>Fechar Comanda</button>";}?>

 <a href="consulta.php">
  
    <button id="accept-favor">Confirmar</button>
</a>


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

   
  </script>

</body>
</html>