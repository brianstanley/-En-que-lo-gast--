<?php
 include "clases.php";
 $if_login = new usuario();// instancio la clase usuario
 $if_login->if_login_index();// llamo al metodo if login que verifica si hay iniciado una session, si hay redirreciona al panel si no, muestra el html 

 ?>

<!DOCTYPE html>
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
    function LoginDialogo(){
    	$('#capaOscura').css('display','block');
    	//$('html').css('overflow','hidden');
        $('#dialogoLogin').dialog(

        {
        	open:true,
        	width:400,
  	     	resizable:false,
  	     	position:'center',
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
	function comprobar(){	
		var usuario = document.forms['form_registro'].usuario_reg.value;	
		var pass = 	document.forms['form_registro'].pass_reg.value;
		var pass_conf = 	document.forms['form_registro'].pass_conf.value;
		var bandera= true;
		if(usuario=='' | usuario==null){
			alert('Complete el campo Usuario por favor');
			var bandera = false;	
		}
		if(pass=='' | pass==null){
			alert('Complete el campo Contraseña por favor');
			var bandera = false;	
		}
		if(pass_conf != pass){
			alert('Las contraseñas no coinciden');	
			var bandera=false;
		}	
	
		if(bandera){
			document.form_registro.submit()
		}	
	
	}	
    </script>

	
</head>

	<?php
		if(@$_SESSION['error_login']){
 			echo "<body onload='LoginDialogo();'>";
 			session_destroy();
 		}elseif (@$_SESSION['error_login2']) {
 			echo "<body onload='RegistroDialogo();'>";
 		}{
 			echo "<body>";
 		}
	?>
	<div id="capaOscura"></div>
	<div id="dialogoSobre" title="&iquest;En qu&eacute; lo gast&eacute; ?">
		<p><?php include 'sobresto.html'; ?></p>
	</div>
	<div id="dialogoLogin" title="Ingresar">
		<form method="post" action="comprobar.php">
		<table>
			<tr>
				<td>
					Usuario
				</td>	
				<td>
					<input type="text" name="user">
				</td>
			</tr>
			<tr>
				<td>Contrase&ntilde;a</td>
				<td><input type="password" name="pass"></td>
			</tr>
			<tr>
				<td>
				</td>	
				<td><input type="submit" value="Entrar"></td>
			</tr>
			<?php
				if(@$_SESSION['error_login']){
					echo "<tr><td id='error'>Usuario o clave incorrecto</td></tr>";
				}	
			?>
		</table>
		</form>
	</div>
	<div id="dialogoRegistro" title="Registro">
		<?php
		require_once "captcha/recaptchalib.php";
		$publickey="6Leyl9QSAAAAAKCPVHSwFejNYYpluyLggUfaLN70";
		?>
		<form method="post" name="form_registro" action="proc_reg.php">
		<table summary="" >
			<tr>
				<td>
				Usuario:
				</td>
				<td>
					<input type="text" name="usuario_reg" class="form-login">
				</td>
			</tr>
			<tr>
				<td>	
					Contrase&ntilde;a:
				</td>
				<td>
					<input type="password" name="pass_reg" class="form-login">
				</td>
			</tr>
			<tr>
				<td>
					Repita su Contrase&ntilde;a:
				</td>
				<td>
					<input type="password" name="pass_conf" class="form-login">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<?php echo recaptcha_get_html($publickey); ?>
				</td>
			</tr>	
			<tr>
				<td>
				</td>
				<td>
					<input type="button" onclick="comprobar()" value="Registrarme">
				</td>
			</tr>
		</table>

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
				<a href="javascript:void(0);" onclick="LoginDialogo();">Ingresar</a> | <a href="javascript:void(0);" onclick="sobreDialogo();">Sobre</a> | <a href="javascript:void(0);" onclick="RegistroDialogo();">Registro</a>
			</nav>
		</div> <!-- fin cont_head -->
	</header>	
	<div id="content">
		<section  id="slid_pe">
			<div id="term" class='terminos'>
				<h2>T&eacute;rminos y Condiciones</h2>
			
				<ul>
					<li>1) <b>&iquest;En qu&eacute; lo gast&eacute;?</b> no recopila ninguna informaci&oacute;n personal.</li>
					<li>2) Para utilizar <b>&iquest;En qu&eacute; lo gast&eacute;?</b> debe estar registrado en el sitio.</li>
					<li>3) <b>&iquest;En qu&eacute; lo gast&eacute;?</b> es una aplicaci&oacute;n totalmente libre y gratuita.</li>
					<li>4) La informaci&oacute;n que guarda <b>&iquest;En qu&eacute; lo gast&eacute;?</b> en su base de datos no es compartida,<br> vendida ni vista sin el permiso del usuario.</li>
					<li>5) <b>&iquest;En qu&eacute; lo gast&eacute;?</b> puede usar la informaci&oacute;n que recopila para hacer estad&iacute;sticas que ser&aacute;n <br> compartidas con el usuario.</li>
					<li>6) <b>&iquest;En qu&eacute; lo gast&eacute;?</b> puede cambiar sus <b>t&eacute;rminos y condiciones</b> sin previo aviso</b>.</li>

				</ul>
			</div>	
		</section>
		<br>
		<br>
		<br><br>
		<br>
		<br>
	</div> <!-- fin content -->	
	<?php include "includes/footer.php"; ?>