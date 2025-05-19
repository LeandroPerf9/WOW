<?php 
include('ligaDados.php'); 
$db = new ligaDados();

//Registar Utilizador
if (isset($_POST['registar'])){
  if(isset($_POST['utilizador']) && isset($_POST['passe1']) && isset($_POST['passe2'])) {
	if($_POST['pass1'] == $_POST['pass2']){
	  $db->registo($_POST['utilizador'],$_POST['pass1']);
	}
	else{
	  echo("Password não coincide");
	}
  }
}

//Efetuar o login
if(isset($_POST['login'])){
  if(isset($_POST['utilizador']) && isset($_POST['passe'])) {
	if(!empty($_POST['passe']) && !empty($_POST['utilizador'])){
	  $db->login($_POST['utilizador'],$_POST['passe']);
	}
	else{
	  echo("Preencha todos os campos");
	}
  }
}

if(isset($_GET['m'])){
	$db->listar_trotinetes($_GET['m']);
}