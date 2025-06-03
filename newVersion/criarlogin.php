<?php
require_once 'ligaDados.php';
$db = new ligaDados();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($db->processarRegisto($_POST)) {
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>World On Wheels</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php echo $db->renderNavegador(); ?>
<?php echo $db->renderMensagens(); ?>

<section class="textContainer">
    <div class="bloco" align="center">
        <br>
        <h2 align="center">Registar Novo utilizador</h2>
        <form name="login" method="POST">
            <fieldset>
                <legend>
                    <h3>Novo Registo</h3>
                </legend>
                <p>
                    <label>Utilizador:</label>
                    <input type="text" id="utilizador" name="utilizador" placeholder="Utilizador" required/>
                </p>
                <p>
                    <label>Password:</label>
                    <input type="password" id="passe1" name="passe1" placeholder="Palavra Passe" required/>
                </p>
                <p>
                    <label>Password:</label>
                    <input type="password" id="passe2" name="passe2" placeholder="Reescrever Palavra Passe" required/>
                </p>
                <p>
                    <input type="submit" id="btnRegistar" name="registar" value="Registar" style="color:#fff; background:#337ab7; padding:10px; margin-left:100px;"/>
                </p>
            </fieldset>
        </form>
        <br><br>
    </div>
</section>

<script src="script.js"></script>
<footer>
    <p>© 2025 World On Wheels. Todos os direitos reservados</p>
</footer>
</body>
</html>