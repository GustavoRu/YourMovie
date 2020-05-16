<?php 
	function conectar(){
		$conexion = new mysqli("localhost", "root", "","peliculas_datos");
		if($conexion->connect_errno){
			die('Error de conexion a la db.');
		}
		return $conexion;
  }
  
