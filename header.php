<html>
<head>
	<meta charset="UTF-8">
	<title>Your Movie</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>
	<div class="header">
		<div class="container">
			<ul class="nav">
				<li> <a href="index.php" class="logo">Your Movie</a></li>
				<li> 
				 	<form class="formulario_buscar" action="buscar.php" onsubmit=""> 
				 		 <input placeholder="Busca un año de estreno, genero o nombre" type="" class="buscar" name="busqueda" value="<?php if(isset($_GET['busqueda'])){ echo $_GET['busqueda'];} ?>">

				 		 <div class="ordenar">
								<p>Ordenar por:</p>
								<div class="ordenar-contenido">
									<select name="criterios" id="">
										<option value="anio"
									<?php if(isset($_GET['criterios'])){ ?>	
										<?php 
											if ($_GET['criterios'] == 'anio'){
												echo "selected";
											} 
										?>
									<?php } ?>	
										>Año</option>
										<option value="nombre"
									<?php if(isset($_GET['criterios'])){ ?>	
										<?php 
											if ($_GET['criterios'] == 'nombre'){
												echo "selected";
											} 
										?>	
									<?php }else {echo "selected";} ?>	
										>Nombre</option>
									</select>
								</div>
						 </div>
					</form>
				</li>
			<?php 
			  include 'autenticador.php';
				$autenticador = new autenticador;
			?>	  	
			<?php if (!($autenticador->estaLogeado())) { ?>
				<li><a href="login.php" class="login">Login</a>|<a href="registrarse.php">Registrarse</a></li>
			<?php }else { ?>
				<li><i class="fas fa-user"></i><?php  echo $_SESSION['usuario']['nombreusuario']?></li>
				<li><a href="cerrarSesion.php">Cerrar Sesion</a></li>
			<?php } ?>
			
			</ul>
		</div>		
	</div>
	