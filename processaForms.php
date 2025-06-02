<?php 
include('ligaDados.php'); 
$db = new ligaDados();

// Registar Utilizador
if (isset($_POST['registar'])){
  if(isset($_POST['utilizador']) && isset($_POST['passe1']) && isset($_POST['passe2'])) {
    if($_POST['passe1'] == $_POST['passe2']){
      $db->registo($_POST['utilizador'], $_POST['passe1']);
    }
    else{
      echo("Password não coincide");
    }
  }
}

// Efetuar o login
if(isset($_POST['login'])){
  if(isset($_POST['utilizador']) && isset($_POST['passe'])) {
    if(!empty($_POST['passe']) && !empty($_POST['utilizador'])){
      $db->login($_POST['utilizador'], $_POST['passe']);
    }
    else{
      echo("Preencha todos os campos");
    }
  }
}

// Redirecionar para o catálogo filtrado por marca
if(isset($_GET['m'])){
  $marca_id = intval($_GET['m']);
  header("Location: urbanglidecatalog.php?m=" . $marca_id);
  exit();
}
?>