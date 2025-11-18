<!DOCTYPE html>
<html>
<head>
    <title>Consultar e Editar Produtos</title>
</head>
<body>
    <h2>Modificar Produto</h2>
    <?php
    include('conexao.php');
    include('menu.php');

    // Ensure a user with the appropriate permissions is logged in
    if ($_SESSION['tipo'] != 0) {
        header("Location:index.php");
        exit(); // Stop further script execution
    }

    // Set error display to false for production
    ini_set('display_errors', FALSE);

    echo "Pesquisar Nome do Produto: <input type='text' name='dado' id='name-filter-input'>";

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product_id = $_POST['product_id'];
        $preco = $_POST['preco'];
        $valorCompra = $_POST['valorCompra'];
        $disponivel = isset($_POST['disponivel']) ? 1 : 0;
        $categoria = $_POST['categoria']; // Assuming category is received

        // Update product information in the database using prepared statements
        $stmt = $conn->prepare("UPDATE produtos SET preco = ?, disponivel = ?, valorCompra = ?, categoria = ? WHERE produto_id = ?");
        $stmt->bind_param("diidi", $preco, $disponivel, $valorCompra, $categoria, $product_id);

        if ($stmt->execute()) {
            echo "<script>alert('Informações do produto atualizadas com sucesso.');</script>";
        } else {
            echo "Erro ao atualizar as informações do produto ID: " . $product_id . " - " . $stmt->error;
        }
    }

    // Retrieve products from the database
    $sql = "SELECT * FROM produtos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table id='products-table'>";
        echo "<tr><th>ID</th><th>Nome</th><th>Preço</th><th>Valor na Compra</th><th>Disponível</th><th>Categoria</th><th>Ação</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo '<form method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '">';
            echo '<tr>';
            echo "<td>".$row['produto_id']."</td>";
            echo "<td>".$row['nome']."</td>";
            // ... Display other columns here
            echo '<td><input type="number" name="preco" value="'.$row['preco'].'" step="0.01" required></td>';
            echo '<td><input type="number" name="valorCompra" value="'.$row['valorCompra'].'" step="0.01" required></td>';
            echo '<td><select name="categoria" required>
                    <option value="1" '.($row['categoria'] == 1 ? 'selected' : '').'>Bebidas Alcoólicas</option>
                    <option value="2" '.($row['categoria'] == 2 ? 'selected' : '').'>Bebidas Não Alcoólicas</option>
                    <option value="3" '.($row['categoria'] == 3 ? 'selected' : '').'>Porções</option>
                    <option value="4" '.($row['categoria'] == 4 ? 'selected' : '').'>Cigarros</option>
                    <option value="5" '.($row['categoria'] == 5 ? 'selected' : '').'>Outros</option>
                </select></td>';
            echo '<td><input type="checkbox" name="disponivel" '.($row['disponivel'] == 1 ? 'checked' : '').'></td>';
            echo '<td>
                    <input type="hidden" name="product_id" value="'.$row['produto_id'].'">
                    <input type="submit" value="Salvar">
                </td>';
            echo '</tr>';
            echo '</form>';
        }
        echo "</table>";
    } else {
        echo "Não foram encontrados produtos.";
    }

    // Close the database connection
    $conn->close();
    ?>

    <!-- JavaScript for filtering table rows by name -->
    <script>
    const nameFilterInput = document.getElementById('name-filter-input');
    const productsTable = document.getElementById('products-table');

    nameFilterInput.addEventListener('input', function() {
        const filterValue = nameFilterInput.value.toLowerCase();
        const rows = productsTable.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const productName = rows[i].getElementsByTagName('td')[1]; // Assuming product name is in the second column

            if (productName) {
                const value = productName.textContent.toLowerCase();

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
