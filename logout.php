<?php
session_start();
include('ligaDados.php');

$db = new ligaDados();
$db->logout();
?>
