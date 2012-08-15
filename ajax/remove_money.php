<?php
include "../clases.php";
$if_login = new usuario();// instancio la clase usuario
$if_login->if_login();
$plata_saca=$_POST['cantidad'];
$razon = $_POST['razon'];
$seguridad  = new comprobaciones();
$seguridad->comp_add_rem($plata_saca);//si infringe la seguridad se corta la ejecucion del script
$procesar = new modelos();
$procesar->remove_money($plata_saca,$razon);

 
  
 ?>