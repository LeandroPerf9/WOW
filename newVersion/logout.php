<?php
require_once 'ligaDados.php';
$db = new ligaDados();
$db->logout();
header("Location: index.php");
exit();
?>