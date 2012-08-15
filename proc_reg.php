<?php
include 'clases.php';
include 'includes/head.php';
?>


<?php
		if(@$_SESSION['error_login']){
 			echo "<body onload='LoginDialogo();'>";
 			session_destroy();
 		}else{
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
		<section id="slid_pe">
			<h2>
				<?php	
				$registro = new modelos();
				$registro->registro($_POST['usuario_reg'],$_POST['pass_reg']);
				?>
			</h2>	
		</section>
		<br>

	</div> <!-- fin content -->	


<?php include "includes/footer.php"; ?>