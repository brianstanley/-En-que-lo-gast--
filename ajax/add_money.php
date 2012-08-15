<?php
include "../clases.php";
$if_login = new usuario();// instancio la clase usuario
$if_login->if_login();
$plata=$_POST['cantidad'];
$seguridad  = new comprobaciones();
$seguridad->comp_add_rem($plata);//si infringe la seguridad se corta la ejecucion del script
$procesar = new modelos();
$procesar->add_money($plata);

 
  
 ?>