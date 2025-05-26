<?php
include('ligaDados.php');

// Obtém o ID do modelo da query string
$modelo_id = isset($_GET['m']) ? intval($_GET['m']) : 0;

// Prepara a query para buscar as trotinetes do modelo especificado
$query = "SELECT * FROM trotinetes WHERE id_modelo = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $modelo_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Catálogo Urbanglide</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('navegador.php'); ?>

<section>
    <h1>Catálogo de Trotinetes</h1>

    <?php
    // Verifica se foram encontradas trotinetes
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<thead><tr><th>Modelo</th><th>Descrição</th><th>Preço</th><th>Imagem</th></tr></thead>';
        echo '<tbody>';

        // Loop através dos resultados e exibir cada trotinete na tabela
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['modelo']) . '</td>';
            echo '<td>' . htmlspecialchars($row['descricao']) . '</td>';
            echo '<td>' . htmlspecialchars($row['preco']) . '</td>';
            echo '<td><img src="' . htmlspecialchars($row['imagem']) . '" alt="Imagem da trotinete" width="100"></td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>Nenhuma trotinete encontrada para este modelo.</p>';
    }
    ?>

</section>

<footer>
    <p>© 2025 World On Wheels. Todos os direitos reservados</p>
</footer>

</body>
</html>

<?php
// Fechar a conexão
$stmt->close();
$conn->close();
?>