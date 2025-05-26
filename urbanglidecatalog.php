<?php
include('ligaDados.php');

// Instancia a classe de ligação
$db = new ligaDados();

// Obtém o ID do modelo da query string
$modelo_id = isset($_GET['m']) ? intval($_GET['m']) : 0;

// Prepara a query para buscar as trotinetes do modelo especificado
$sql = "SELECT * FROM trotinetes WHERE id_modelo = :id_modelo";
$stmt = $db->liga->prepare($sql);
$stmt->bindParam(':id_modelo', $modelo_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Trotinetes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('navegador.php'); ?>

<section>
    <h1>Catálogo de Trotinetes</h1>

    <?php if (count($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Modelo</th>
                    <th>Descrição</th>
                    <th>Preço (€)</th>
                    <th>Imagem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['modelo']) ?></td>
                        <td><?= htmlspecialchars($row['descricao']) ?></td>
                        <td><?= number_format($row['preco'], 2, ',', '.') ?></td>
                        <td><img src="<?= htmlspecialchars($row['imagem']) ?>" alt="Imagem da trotinete" width="100"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma trotinete encontrada para este modelo.</p>
    <?php endif; ?>
</section>

<footer>
    <p>© 2025 World On Wheels. Todos os direitos reservados</p>
</footer>

</body>
</html>