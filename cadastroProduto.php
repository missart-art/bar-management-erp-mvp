<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Produto</title>
    <?php session_start(); include('menu.php'); if($_SESSION['tipo'] != 0){
        header("Location:index.php");
}?>
</head>
<body>
    <h2>Cadastrar Novo Produto</h2>
    <form method="post" action="adicionarProduto.php">
        <label for="name">Nome do Produto:</label>
        <input type="text" name="name" id="name" required><br><br>
        
        <label for="category">Categoria:</label>
        <select name="category" id="category">
            <option value="1">Bebidas Alcoólicas</option>
            <option value="2">Bebidas Não Alcoólicas</option>
            <option value="3">Porções</option>
            <option value="4">Cigarros</option>
            <option value="5">Outros</option>
        </select><br><br>
        
        <label for="price">Preço:</label>
        <input type="number" name="price" id="price" step="0.01" required><br><br>

        <label for="price">Preço na Compra:</label>
        <input type="number" name="valorCompra" id="price" step="0.01" required><br><br>
        
        <input type="submit" value="Adicionar Produto">
    </form>
</body>
</html>