<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registrarse</title>
	<link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>
	<?php 
		include 'autenticador.php';
		$autenticador = new autenticador();
	
		if ($autenticador->estaLogeado()) {
			header('Location: index.php');
			exit;}

	 ?>

	<div class="container-formulario">
		  <div>
		  	<h1>Registrarse:</h1>
		  </div>

			<form action="validarRegistro.php" onsubmit="return validarRegistro(this);" method="post">
				<div class="input">
					<input type="text" name="email" placeholder="Email">
				</div>
				<div class="input">
					<input type="text" name="nombre" placeholder="Nombre:">
				</div>
			  <div class="input">
			  	<input type="text" name="apellido" placeholder="Apellido:">
			  </div>
				<div class="input">
					<input type="text" name="nombreusuario" placeholder="Nombre de usuario:">
				</div>
				<div class="input">
					<input type="password" name="contrasenia" placeholder="Contraseña:">
				</div>
				<div class="input">
					<input type="password" name="repcontrasenia" placeholder="Repetir contraseña:">
				</div>
				<div class="input">
					<input type="submit" name="submit">
				</div>
				
			</form>
			
			<ul id="errores" style="dysplay:none"></ul>

			<?php if (isset($_SESSION['errores'])): ?>
				<ul class="erroresphp" id="errores" style="display:block;">
					<?php 
						echo $_SESSION['errores']; 
						unset($_SESSION['errores']);
					?>
				</ul>
			<?php endif ?>
	
	</div>
	<!-- <script src="js/validacion.js"></script> -->
</body>
</html>