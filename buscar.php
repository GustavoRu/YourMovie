<?php 
	include "header.php";

	if (!$_GET) {
		header('Location: index.php');
	}
	$busqueda = $_GET['busqueda'];
	$criterio = $_GET['criterios'];
	
	$conexion = conectar();
  //id del genero para usarlo en la consulta de la busqueda
	$sql = "SELECT id, genero FROM generos WHERE genero like '%$busqueda%'";
	$genero = $conexion->query($sql)->fetch_assoc();
	$genero_id = $genero['id'];

	/*$sql = "SELECT id, nombre, anio, sinopsis, generos_id 
					FROM peliculas 
					WHERE nombre like '%$busqueda%' or anio like '%$busqueda%' or generos_id = '$genero_id'
					ORDER BY $criterio";

	$resultados = $conexion->query($sql); */

 ?>
 <?php 	
			$conexion = conectar();
			
			$pagina = isset($_GET['p']) ? (int)$_GET['p'] : 1; 
			$peliculasPorPagina = 10;

			$inicio = ($pagina > 1) ? ($pagina * $peliculasPorPagina - $peliculasPorPagina) : 0;
			$sql = "SELECT id, nombre, anio, sinopsis, generos_id 
					FROM peliculas 
					WHERE nombre like '%$busqueda%' or anio like '%$busqueda%' or generos_id = '$genero_id'
					ORDER BY $criterio";

			$resultados = $conexion->query($sql);
			$total_peliculas = $resultados->num_rows;


			/*$sql = "SELECT id, nombre, anio, sinopsis, generos_id FROM peliculas";
			$peliculas = $conexion->query($sql);
			$total_peliculas = $peliculas->num_rows;*/
			$sql = "SELECT id, nombre, anio, sinopsis, generos_id 
					FROM peliculas 
					WHERE nombre like '%$busqueda%' or anio like '%$busqueda%' or generos_id = '$genero_id'
					ORDER BY $criterio LIMIT $inicio, $peliculasPorPagina";
			$resultados =$conexion->query($sql);

			/*$sql = "SELECT id, nombre, anio, sinopsis, generos_id FROM peliculas LIMIT $inicio, $peliculasPorPagina";
			$peliculas = $conexion->query($sql);*/
			
			$numero_paginas = ceil($total_peliculas / $peliculasPorPagina);
		?>
	


  <div class="container">
 		<div class="listado">
 			<h1>Resultados de la busqueda (<?php echo $total_peliculas ?>): </h1>
 		</div>
 		<?php if ($resultados->num_rows == 0) { ?>
 			<h3>No se encontraron resultados para: <?php echo $busqueda; ?></h3>
 		<?php } ?>
		
		

  <?php if ($resultados->num_rows !=0) { ?>
 		<div class="paginacion">
			<ul>
				<?php if($pagina == 1){ ?>
					<li class="disabled">&laquo;</li>
				<?php } else { ?>
					<a href="buscar.php?p=<?php echo $pagina - 1; ?>&busqueda=<?php echo $busqueda; ?>&criterios=<?php echo $criterio; ?>"><li>&laquo;</li></a>
				<?php } ?>

				<?php for($i = 1; $i<=$numero_paginas; $i++){ ?>
					<?php if ($i == $pagina){ ?>
						<a href="buscar.php?p=<?php echo $i; ?>&busqueda=<?php echo $busqueda; ?>&criterios=<?php echo $criterio; ?>"><li class="actual"><?php echo $i; ?></li></a>
					<?php } else { ?>
						<a href="buscar.php?p=<?php echo $i; ?>&busqueda=<?php echo $busqueda; ?>&criterios=<?php echo $criterio; ?>"><li><?php echo $i; ?></li></a>
					<?php } ?>
				<?php } ?>
				
				<?php if($pagina == $numero_paginas){ ?>
					<li class="disabled">&raquo;</li>
				<?php } else { ?>
					<a href="buscar.php?p=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>&criterios=<?php echo $criterio; ?>"><li>&raquo;</li></a>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
 		<?php while ($resultado = $resultados->fetch_assoc()) {?>
 			<article class="movie">
			  <div class="foto">
			  	<a href="pelicula.php?id=<?php echo $resultado['id']; ?>" class="foto-link">
					  <img src="mostrarImagen.php?id=<?php echo $resultado['id']; ?>" >
					</a>
				</div>
				<div class="info">
					<div class="titulo"> 
						<h2> 
							<a href="pelicula.php?id=<?php echo $resultado['id'];?>" class="titulo-movie">
								<?php echo $resultado['nombre']; ?>
							</a>
						</h2>
					</div>
					
					<div class="fecha"> 
						<span class="fecha-span"> <?php echo $resultado['anio'] ?> / </span>
						<?php
							$generos_id = $resultado['generos_id'];
							$sql = "SELECT genero FROM generos WHERE id = '$generos_id'";
							$genero2 = $conexion->query($sql);
						?>
						<span><?php echo $genero2->fetch_assoc()['genero']; ?></span>
					</div>
					<div class="sinopsis"> <?php echo $resultado['sinopsis']; ?></div>

					<?php //las veces que comentaron y puntuaron la pelicula
						$id_pelicula = $resultado['id'];
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

					<div class="calificacion"><?php echo $promedio ?></div>		
				</div>
			</article>
		<?php } ?>		

 	</div>