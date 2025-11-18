<?php 

include('conexao.php');
include('menu.php');

?>
<head>
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

<body onload="zoom()" style="font-size: 25px;">

	<?php if($_SESSION['tipo'] == 0){echo "Bem vindo Admin";}else{echo "Bem vindo Atendente";} ?>

<table border="1">

    <tr>
        <?php if ($_SESSION['tipo'] == 0) echo "<th>Admin</th>"; ?>
        <th></th>
    </tr>
    <tr><?php if ($_SESSION['tipo'] == 0): ?>
        <td>
            
                <a href="cadastroProduto.php"><button>Cadastrar Produto</button></a>
            
        </td><?php endif; ?>
        <td>
            <a href="consulta.php"><button>Consultar Comanda</button></a>
        </td>
    </tr>
    <tr>
    	<?php if ($_SESSION['tipo'] == 0): ?>
        <td>
            
                <a href="modificaProduto.php"><button>Modificar Produto</button></a>
            
        </td><?php endif; ?>

        <td>
            <a href="consultarProdutos.php"><button>Consultar Produtos</button></a>
        </td>
    </tr>
    <tr><?php if ($_SESSION['tipo'] == 0): ?>
        <td>
            <a href="consultaFechadas.php"><button>Consultar Comandas Fechadas</button></a>
        </td> <?php endif; ?>
        <td>
            <a href="login.php"><button>Página de Login</button></a>
        </td>
    </tr>
    <tr></table>

</body>