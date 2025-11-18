<?php
include('menu.php');
include('conexao.php');

$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);

echo "Pesquisar Produtos:<input type='text' id='name-filter-input'><br><br>";

echo "<label for='categoria-filter'>Filtrar por Categoria:</label>";
echo "<select id='categoria-filter'>";
echo "<option value='0'>Todas</option>"; // Option to show all categories
echo "<option value='1'>Bebidas Alcoólicas</option>";
echo "<option value='2'>Bebidas Não Alcoólicas</option>";
echo "<option value='3'>Porções</option>";
echo "<option value='4'>Cigarros</option>";
echo "<option value='5'>Outros</option>";
echo "</select>";

if ($result->num_rows > 0) {
    echo "<table id='name-table'>";
    echo "<tr><th>ID</th><th>Nome</th><th>Categoria</th><th>Preço</th></tr>";

    while ($row = $result->fetch_assoc()) {
        if ($row['disponivel'] == 1) {
            echo "<tr>";
            echo "<td>" . $row['produto_id'] . "</td>";
            echo "<td>" . $row['nome'] . "</td>";
            if($row['categoria'] == 1){
                $categoria = 'Bebidas Alcoólicas';
            };
            if($row['categoria'] == 2){ $categoria = 'Bebidas Não Alcoólicas';};
            if($row['categoria'] == 3){ $categoria = 'Porções';};
            if($row['categoria'] == 4){ $categoria = 'Cigarros';};
            if($row['categoria'] == 5){ $categoria = 'Outros';};
            echo "<td data-categoria='" . $row['categoria'] . "'>" . $categoria . "</td>"; // Use data attribute to store the category value
            echo "<td>R$ " . $row['preco'] . "</td>";
            echo "</tr>";
        }
    }

    echo "</table>";
} else {
    echo "Não foram encontrados produtos.";
}
?>

<script>
    const nameFilterInput = document.getElementById('name-filter-input');
    const categoriaFilter = document.getElementById('categoria-filter');
    const nameTable = document.getElementById('name-table');

    nameFilterInput.addEventListener('input', applyFilter);
    categoriaFilter.addEventListener('change', applyFilter);

    function applyFilter() {
        const nameFilterValue = nameFilterInput.value.toLowerCase();
        const categoriaFilterValue = categoriaFilter.value;

        const rows = nameTable.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByTagName('td')[1];
            const categoryCell = rows[i].getElementsByTagName('td')[2];
            
            const nameValue = nameCell.textContent.toLowerCase();
            const categoryValue = categoryCell.getAttribute('data-categoria'); // Get data attribute value
            
            const nameMatchesFilter = nameValue.includes(nameFilterValue);
            const categoryMatchesFilter = categoriaFilterValue === '0' || categoryValue === categoriaFilterValue;

            if (nameMatchesFilter && categoryMatchesFilter) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
</script>
