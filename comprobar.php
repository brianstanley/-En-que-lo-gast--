<?php
include "clases.php";

$usuario = $_POST['user'];
$pass = $_POST['pass'];


$login = new usuario();
$login->login($usuario,$pass);
?>