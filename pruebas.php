<?php
$diaResto = time()-(7*24*60*60); //Te resta un dia (2*24*60*60) te resta dos y //asi...
$dia_fin = date('Y-m-d', $diaResto); //Formatea dia

include 'clases.php';
$consulta = "SELECT fecha FROM historial_salidas WHERE id_user=".$_SESSION['ses_id_user']."  ORDER by fecha DESC LIMIT 7";
$sql = mysql_query($consulta);
$arrDias= array("Relleno","Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","
	Sabado");
while($res = mysql_fetch_object($sql)):
	$fecha = explode(" ", $res->fecha);
	$diex = explode("-",$fecha[0]);
	$time = strtotime($fecha[0]);
	$dia = date("N",$time);
	$newFecha = date("Y-m-d H:i:s");
	//echo $newFecha;
	if($res->fecha<$dia_fin):
		echo "es menor";
	endif;	
	//exit();
endwhile;
?>