<?php 
	include 'db.php';
	session_start();
	class autenticador{

		function estaLogeado(){
			return isset($_SESSION['usuario']);
			
		}

		function cerraSesion(){
			unset($_SESSION['usuario']);
		}

		function loginUser ($nombreusuario, $contrasenia){
		$conexion = conectar();

		$sql = "SELECT id, nombreusuario, apellido, nombre, email 
						FROM usuarios
						WHERE nombreusuario = '$nombreusuario' AND password = '$contrasenia'";
		
		$resultado = $conexion->query($sql);

		if($usuario = $resultado->fetch_assoc()){
			$_SESSION['usuario'] = $usuario;
		} else {
			throw new Exception("Credenciales inválidas", 1);
		}
	}
	}

 ?>