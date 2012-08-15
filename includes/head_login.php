<?php require "clases.php"; ?>
<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<head>
	<title>Bienvenido a &iquest;En qu&eacute; lo gast&eacute;?, gesti&oacute;n personal de dinero.</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
    <link rel="stylesheet" href="css/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.nivo.slider.js"></script>
   	<link type="text/css" href="css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#slider').nivoSlider();
    	
    });
    function sobreDialogo(){
    	$('#capaOscura').css('display','block');
        $('#dialogoSobre').dialog(

        {
        	open:true,
        	width:700,
  	     	resizable:false,
  	     	position:'top',
  	        close: function(ev, ui) { $('#capaOscura').css('display','none');     	$('html').css('overflow','visible')
  	    							}
        }
        );
	}
    function RegistroDialogo(){
    	$('#capaOscura').css('display','block');
        $('#dialogoRegistro').dialog(

        {
        	open:true,
        	width:600,
  	     	resizable:false,
  	     	position:'center',
  	        close: function(ev, ui) { $('#capaOscura').css('display','none');     	$('html').css('overflow','visible')
  	    							}
        }
        );
	}
    </script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization','1.0',{'packages':['corechart']});
      google.setOnLoadCallback(drawChart);
      function drawChart(){
         //creo y lleno la tabla
        var data = google.visualization.arrayToDataTable([
        <?php
        $consulta = "SELECT * FROM historial_salidas WHERE id_user=".$_SESSION['ses_id_user']."  ORDER by fecha DESC LIMIT 7";
        $sql = mysql_query($consulta);
        $arrDias= array("Relleno","Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","
         Sabado");
        echo "['Dias', 'Gastos(pesos)'],";
        $elDia = array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0, "Sabado"=>0,"Domingo"=>0);
        $diaResto = time()-(7*24*60*60); //Te resta un dia (2*24*60*60) te resta dos y //asi...
        $dia_fin = date('Y-m-d', $diaResto); //Formatea dia
        while($res = mysql_fetch_object($sql)):
          $fecha = explode(" ", $res->fecha);
          $diex = explode("-",$fecha[0]);
          $time = strtotime($fecha[0]);
          $dia = date("N",$time);
          if($res->fecha>$dia_fin){
            if($dia == 2){
             $elDia['Lunes']=$elDia['Lunes']+$res->salio;    
            }elseif($dia == 3){
              $elDia['Martes']=$elDia['Martes']+$res->salio;    
            }elseif($dia == 4){
              $elDia['Miercoles']=+$res->salio;
            }elseif($dia == 5){
              $elDia['Jueves']=+$res->salio;    
            }elseif($dia == 6){
              $elDia['Viernes']=+$res->salio;    
            }elseif($dia == 7){
              $elDia['Sabado']=+$res->salio;    
            }elseif($dia == 1){
              $elDia['Domingo']=+$res->salio;    
            }
          }
        endwhile; 
        ?>
        ['Lunes', <?php echo $elDia['Lunes']; ?>],
        ['Martes', <?php echo $elDia['Martes']; ?>],
        ['Miércoles',<?php echo $elDia['Miercoles']; ?>],
        ['Jueves',  <?php echo $elDia['Jueves']; ?>],
        ['Viernes',  <?php echo $elDia['Viernes']; ?>],
        ['Sábado', <?php echo $elDia['Sabado']; ?>],
        ['Domingo',  <?php echo $elDia['Domingo']; ?>]
        ]);
        // Crear y dibujar el grafico
        new google.visualization.ColumnChart(document.getElementById('chart_div')).
        draw(data,
           {title:"Gastos de los ultimos 7 días",
            width:550, height:400,
            hAxis: {title: "Gastos"}}
        );
      }
    </script>
	
</head>
<body>
	<br>
	<div id="capaOscura"></div>
	
	
  <div id="dialogoSobre" title="&iquest;En qu&eacute; lo gast&eacute; ?">
    <p><?php require '../sobresto.html'; ?></p>
  </div>
	<div id="fondo1"> &nbsp;</div>
	<header>

		<div id="cont_head">	
			<div id="logo">
				 <img src="images/logo.png" width=120>
			</div>
			<div id="slogan">
				<h1>
					No te olvidas m&aacute;s!
				</h1>
			</div>
        <br>
        	
			<nav id="panel">
				<a href="index.php">Inicio</a> | <a href="javascript:void(0);" onclick="sobreDialogo();">Sobre</a> | <a href="logout.php" >Cerrar Sesi&oacute;n</a>
			</nav>
		</div> <!-- fin cont_head -->	
	</header>