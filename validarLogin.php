<?php 
	include 'autenticador.php';
	$nombreusuario = $_POST['nombreusuario'];
	$contrasenia = $_POST['contrasenia'];

	$autenticador = new autenticador();

	try{
		$autenticador->loginUser($nombreusuario, $contrasenia);
		header('Location: index.php');
	}catch (Exception $e){
		$_SESSION['errores'] .= '<li>Datos incorrectos.</li>';
		header('Location: login.php');
	}


 ?>