<!DOCTYPE html>
<head>
	<title>Bienvenido a &iquest;En qu&eacute; lo gast&eacute;?, gestión personal de dinero.</title>
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
    	//$('html').css('overflow','hidden');
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
    	//$('html').css('overflow','hidden');
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
     function LoginDialogo(){
      $('#capaOscura').css('display','block');
      //$('html').css('overflow','hidden');
        $('#dialogoLogin').dialog(

        {
          open:true,
          width:400,
          resizable:false,
          position:'center',
            close: function(ev, ui) { $('#capaOscura').css('display','none');       $('html').css('overflow','visible')
                      }
        }
        );
    }   
    </script>

	
</head>
<body>
	<br>
	<div id="capaOscura"></div>
	
	<div id="dialogoSobre" title="&iquest;En qu&eacute; lo gast&eacute; ?">
    <p><?php include 'sobresto.html'; ?></p>
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
			<nav id="panel">
				<a href="#" onclick="LoginDialogo();">Login</a> | <a href="#" onclick="sobreDialogo();">Sobre</a> | <a href="#" onclick="RegistroDialogo();">Registro</a>
			</nav>
		</div> <!-- fin cont_head -->	
	</header>	