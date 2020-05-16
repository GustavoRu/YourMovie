<?php 	
	
	include 'autenticador.php';
	$autenticador = new autenticador;

	$id_usuario = $_SESSION['usuario']['id'];
	$id_pelicula = $_GET['id_pelicula'];
	$comentario = $_GET['comentario'];
	$calificacion = $_GET['puntuacion'];

	if (!($autenticador->estaLogeado())) {
		header('Location: pelicula.php?id='.$id_pelicula);
		$_SESSION['error_comentario'].= '<li>Necesitas loguearte para poder comentar.</li>';
	}else{

		if ($comentario !='') {

			$conexion = conectar();

			$sql = "INSERT INTO comentarios (comentario, fecha, peliculas_id, usuarios_id, calificacion) 
				VALUES ('$comentario', now(), '$id_pelicula', '$id_usuario', '$calificacion')";
			
			try{
				$resultado = $conexion->query($sql);

				$sql= "SELECT COUNT(*),usuarios_id FROM comentarios WHERE usuarios_id= $id_usuario";
				$resultado2= $conexion->query($sql);
				
				if ($resultado2->fetch_assoc()['COUNT(*)'] > 3) {
					$sql= "UPDATE usuarios SET destacado=1 WHERE id= $id_usuario ";
					$resultado3 = $conexion->query($sql);
				}

				header('Location: pelicula.php?id='.$id_pelicula);
			}  catch(Exception $e) {
				$_SESSION['errores'] .= '<li>Error de la base de datos.</li>';
				header('Location: pelicula.php?id='.$id_pelicula);
			}
		}else {
			header('Location: pelicula.php?id='.$id_pelicula);
			$_SESSION['error_comentario'].= '<li>El comentario debe tener al menos un caracter.</li>';
		}
	}	
?>