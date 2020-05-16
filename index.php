<?php 
	include "header.php"; 
?>
	<?php 
		//$autenticador = new autenticador;
		var_dump($_SESSION);
		var_dump($autenticador->estaLogeado()); ?>
	<div class="container">

		<ul id="errores" style="display:none"></ul>
		<ul class="exito" style="display:none"></ul>

			<?php if (isset($_SESSION['errores'])): ?>
				<ul class="erroresphp" id="errores" style="display:block;">
					<?php 
						echo $_SESSION['errores']; 
						unset($_SESSION['errores']);
					?>
				</ul>
			<?php endif ?>

			<?php if (isset($_SESSION['exito'])): ?>
				<ul class="exito" style="display:block;">
					<?php 
						echo $_SESSION['exito']; 
						unset($_SESSION['exito']);
					?>
				</ul>
			<?php endif ?>

		<div class="listado">
			<h1>Listado de peliculas</h1>
		</div>

		<?php 	
			$conexion = conectar();
			
			$pagina = isset($_GET['p']) ? (int)$_GET['p'] : 1; 
			$peliculasPorPagina = 10;

			$inicio = ($pagina > 1) ? ($pagina * $peliculasPorPagina - $peliculasPorPagina) : 0;
			
			$sql = "SELECT id, nombre, anio, sinopsis, generos_id FROM peliculas";
			$peliculas = $conexion->query($sql);
			$total_peliculas = $peliculas->num_rows;

			$sql = "SELECT id, nombre, anio, sinopsis, generos_id FROM peliculas LIMIT $inicio, $peliculasPorPagina";
			$peliculas = $conexion->query($sql);
			
			$numero_paginas = ceil($total_peliculas / $peliculasPorPagina);
		?>

		<div class="paginacion">
			<ul>
				<?php if($pagina == 1){ ?>
					<li class="disabled">&laquo;</li>
				<?php } else { ?>
					<a href="index.php?p=<?php echo $pagina - 1; ?>"><li>&laquo;</li></a>
				<?php } ?>

				<?php for($i = 1; $i<=$numero_paginas; $i++){ ?>
					<?php if ($i == $pagina){ ?>
						<a href="index.php?p=<?php echo $i; ?>"><li class="actual"><?php echo $i; ?></li></a>
					<?php } else { ?>
						<a href="index.php?p=<?php echo $i; ?>"><li><?php echo $i; ?></li></a>
					<?php } ?>
				<?php } ?>
				
				<?php if($pagina == $numero_paginas){ ?>
					<li class="disabled">&raquo;</li>
				<?php } else { ?>
					<a href="index.php?p=<?php echo $pagina + 1; ?>"><li>&raquo;</li></a>
				<?php } ?>
			</ul>
		</div>

		

		<?php while ($pelicula = $peliculas->fetch_assoc()) { ?>
	 		 

			<article class="movie">
			  <div class="foto">
			  	<a href="pelicula.php?id=<?php echo $pelicula['id']; ?>" class="foto-link">
					  <img src="mostrarImagen.php?id=<?php echo $pelicula['id']; ?>" >
					</a>
				</div>
				<div class="info">
					<div class="titulo"> 
						<h2> 
							<a href="pelicula.php?id=<?php echo $pelicula['id'];?>" class="titulo-movie">
								<?php echo $pelicula['nombre']; ?>
							</a>
						</h2>
					</div>
					
					<div class="fecha"> 
						<span class="fecha-span"> <?php echo $pelicula['anio'] ?> / </span>
						<?php
							$generos_id = $pelicula['generos_id'];
							$sql = "SELECT genero FROM generos WHERE id = '$generos_id'";
							$genero = $conexion->query($sql);
						?>
						<span><?php echo $genero->fetch_assoc()['genero']; ?></span>
					</div>
					<div class="sinopsis"> <?php echo $pelicula['sinopsis']; ?></div>

					<?php //las veces que comentaron y puntuaron la pelicula
						$id_pelicula = $pelicula['id'];
						$sql = "SELECT COUNT(*), peliculas_id FROM comentarios WHERE peliculas_id = '$id_pelicula'";
						$cantidad_calificaciones = $conexion->query($sql)->fetch_assoc()['COUNT(*)'];
				
						//consulta para la suma total de las calificaciones
						$sql = "SELECT SUM(calificacion) as total FROM comentarios WHERE peliculas_id = '$id_pelicula'";
						$suma_calificaiones = $conexion->query($sql)->fetch_assoc()['total'];
						//promedio
						if ($suma_calificaiones == 0) {
							$promedio = "Sin calificar";
						} else {
							$promedio = round(($suma_calificaiones / $cantidad_calificaciones), 1, PHP_ROUND_HALF_UP);}
						
					?>

					<div class="calificacion"><?php echo $promedio ?><i class="fas fa-star"></i></div>		
				</div>
			</article>
		<?php } ?>
		
		<div class="paginacion">
			<ul>
				<?php if($pagina == 1){ ?>
					<li class="disabled">&laquo;</li>
				<?php } else { ?>
					<a href="index.php?p=<?php echo $pagina - 1; ?>"><li>&laquo;</li></a>
				<?php } ?>

				<?php for($i = 1; $i<=$numero_paginas; $i++){ ?>
					<?php if ($i == $pagina){ ?>
						<a href="index.php?p=<?php echo $i; ?>"><li class="actual"><?php echo $i; ?></li></a>
					<?php } else { ?>
						<a href="index.php?p=<?php echo $i; ?>"><li><?php echo $i; ?></li></a>
					<?php } ?>
				<?php } ?>
				
				<?php if($pagina == $numero_paginas){ ?>
					<li class="disabled">&raquo;</li>
				<?php } else { ?>
					<a href="index.php?p=<?php echo $pagina + 1; ?>"><li>&raquo;</li></a>
				<?php } ?>
			</ul>
		</div>

	<script src="js/validacion.js"></script>
</body>
</html>