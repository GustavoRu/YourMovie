<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="estilos.css">
	<title>Login</title>
</head>
<body>
	
	<div class="container-formulario">
		  <div>
		  	<h1>Iniciar sesion:</h1>
		  </div>

			<form action="validarLogin.php" onsubmit="return validarLogin(this);" method="post">
				<div class="input">
					<input type="text" name="nombreusuario" placeholder="Nombre de usuario:">
				</div>
				<div class="input">
					<input type="password" name="contrasenia" placeholder="Contraseña:">
				</div>
				<div class="input">
					<input type="submit" name="submit">
				</div>
				
			</form>
			
			<ul id="errores" style="display:none"></ul>
			<ul class="exito" style="display:none"></ul>

			<?php if (isset($_SESSION['errores'])){ ?>
				<ul class="erroresphp" id="errores" style="display:block;">
				<?php 
					echo $_SESSION['errores']; 
					unset($_SESSION['errores']);
				?>
				</ul>
			<?php } ?>

			<?php if (isset($_SESSION['exito'])){ ?>
				<ul class="exito" id="exito" style="display:block;">
				<?php 
					echo $_SESSION['exito']; 
					unset($_SESSION['exito']);
				?>
				</ul>
			<?php } ?>
			¿No tenes cuenta?
			<a href="registrarse.php">Registrarse</a>
	</div>
	<!--<script src="js/validacion.js"></script>-->	
</body>
</html>