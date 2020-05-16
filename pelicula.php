<?php include "header.php"; ?>
	<?php 
		
		$conexion = conectar();
		$id = $_GET['id']; //el id que me pasan por url
		$sql = "SELECT nombre, anio, generos_id, sinopsis FROM peliculas WHERE id = $id";
		$pelicula = $conexion->query($sql)->fetch_assoc(); // genero un arreglo asociativo
	?>
	
	<div class="container">
		<div class="main">
			<div class="imagen-pelicula">
				<img src="mostrarImagen.php?id=<?php echo $id ?>" alt="">
			</div>
			<div class="info-pelicula">
				<div class="titulo-pelicula"> <h1><?php echo $pelicula['nombre'] ?> </h1> </div>
				<div class="fecha"><?php echo $pelicula['anio'] ?></div>
				
				<?php //consulta para mostrar el genero
							$generos_id = $pelicula['generos_id'];
							$sql = "SELECT genero FROM generos WHERE id = '$generos_id'";
							$genero = $conexion->query($sql)->fetch_assoc();
							//genero un arreglo asociativo
						?>
				<div class="genero"> <?php echo $genero['genero']; ?></div>
				<div class="sinopsis-pelicula"><?php echo $pelicula['sinopsis'] ?></div>
				
				<?php //las veces que comentaron y puntuaron la pelicula
						$id_pelicula = $id;
						$sql = "SELECT COUNT(*), peliculas_id FROM comentarios WHERE peliculas_id = '$id_pelicula'";
						$cantidad_calificaciones = $conexion->query($sql)->fetch_assoc()['COUNT(*)'];
				
						//consulta para la suma total de las calificaciones
						$sql = "SELECT SUM(calificacion) as total FROM comentarios WHERE peliculas_id = '$id_pelicula'";
						$suma_calificaiones = $conexion->query($sql)->fetch_assoc()['total'];
						//promedio
						if ($suma_calificaiones == 0) {
							$promedio = "Sin calificar";
						} else {
							$promedio = round(($suma_calificaiones / $cantidad_calificaciones), 1, PHP_ROUND_HALF_UP);
						}
						
					?>


				<div class="calificacion">
					<?php echo $promedio ?><i class="fas fa-star"></i></div>
			</div>
		</div>

		<form action="comentar.php" method="get" onsubmit="return validarComentario(this);">
			<textarea class="comentar" placeholder="Deja un comentario" name="comentario"></textarea>
			<input type="hidden" name="id_pelicula" value="<?php echo $id; ?>">
			<div class="puntuacion-ratio" name="puntuacion">
				<p>Deja una puntuacion:</p>
 			  <input type="radio" name="puntuacion" value="1"> 1
 			  <input type="radio" name="puntuacion" value="2"> 2
 			  <input type="radio" name="puntuacion" value="3" checked> 3
  			<input type="radio" name="puntuacion" value="4"> 4
  			<input type="radio" name="puntuacion" value="5"> 5
			</div>
			<input type="submit" class="boton-comentar">
		</form>
		<ul id="errores" style="dysplay:none"></ul>

			<?php if (isset($_SESSION['error_comentario'])): ?>
				<ul class="erroresphp" id="errores_comentario" style="display:block;">
					<?php 
						echo $_SESSION['error_comentario']; 
						unset($_SESSION['error_comentario']);
					?>
				</ul>
			<?php endif ?>

		<?php // consulta a la tabla de comentarios
			$sql = "SELECT comentario, fecha, peliculas_id, usuarios_id, calificacion FROM comentarios ORDER BY fecha DESC";
			$comentarios = $conexion->query($sql);
			?> 
	
		<div class="lista-comentarios">
			<h2 class="titulo-comentarios">Comentarios</h2>
	<?php while ($comentario = $comentarios->fetch_assoc()){ //array asociativo con los comentarios?>
			<?php 
				$id_pelicula_comentario = $comentario['peliculas_id'];
				
				if ($id == $id_pelicula_comentario) {
					$usuario_id = $comentario['usuarios_id'];
					$sql = "SELECT nombre, apellido, destacado FROM usuarios WHERE id = $usuario_id";
					$nombres = $conexion->query($sql);//traigo nom y ape de la tabla de usuarios usando el usuario id del comentario 
			  ?>
			  <?php $nombre = $nombres->fetch_assoc(); ?>
	 			<?php if($nombre['destacado']==0) {?>
			  <div class="comentario">
			  	
			  	<span class="nombre-usuario"><?php echo $nombre['nombre'];?> <?php echo $nombre['apellido'] ?></span>
				  <p><?php echo $comentario['comentario'] ?></p>
				  <span class="puntuacion">Puntuacion: <?php echo $comentario['calificacion']?></span>
			 	  <div class="fecha-comentario"><?php echo $comentario['fecha'] ?></div>
			 	
			  </div>
			  <?php } ?>
			  <?php if($nombre['destacado']==1) {?>
				<div class="comentario-destacado">
			  	
			  	<span class="nombre-usuario"><?php echo $nombre['nombre'];?> <?php echo $nombre['apellido'] ?></span>
				  <p><?php echo $comentario['comentario'] ?></p>
				  <span class="puntuacion">Puntuacion: <?php echo $comentario['calificacion']?></span>
			 	  <div class="fecha-comentario"><?php echo $comentario['fecha'] ?></div>
			 	
			  </div>
			  <?php } ?>
		  <?php }?>

	<?php } ?>		
		</div>
		
	</div>
	<script src="js/validacion.js"></script>
</body>
</html>