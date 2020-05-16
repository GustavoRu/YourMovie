<?php 
	include 'db.php';

	session_start();

	$conexion = conectar();

	$email = $_POST['email'];
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$nombre_usuario = $_POST['nombreusuario'];
	$contrasenia = $_POST['contrasenia'];
	$rep_contrasenia = $_POST['repcontrasenia'];
	$errores = '';

		// si alguno de los campos esta vacio muestra error en pantalla
	if ($nombre == '' or $apellido == '' or $email == '' or $nombre_usuario == '') {
		$_SESSION['errores'] .= '<li>Complete todos los campos.</li>';
		
		header('Location: registrarse.php');
		exit;
	}
	if(strlen($nombre_usuario) < 6){
			$errores .= '<li>El nombre de usuario debe tener al menos 6 caracteres.</li>';
		}

	if(strlen($contrasenia) < 6){
      $errores .= '<li>La contraseña debe tener al menos 6 caracteres.</li>';
    }
  if (!preg_match('/@/', $email)) {
    	$errores .= '<li> El email no es valido.</li>';
    }  

   if (!preg_match('`[a-z]`',$contrasenia)){
      $errores .= '<li>La contraseña debe tener al menos una letra minúscula.</li>';
      
   }
   if (!preg_match('`[A-Z]`',$contrasenia)){
      $errores .= '<li>La contraseña debe tener al menos una letra mayúscula.</li>';
      
   }
   if ($contrasenia != $rep_contrasenia) {
   		$errores .= '<li>Las contraseñas no coinciden.</li>';
   	
   }
   
   $pattern = '/[\'\/~`\!@#$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?]/';
   if (!((preg_match('`[0-9]`',$contrasenia)) or (preg_match($pattern, $contrasenia)))) {
  		$errores .= '<li>La contraseña debe tener al menos un caracter numérico o un simbolo.</li>';
     	
   }

  
	// si tengo errores los seteo en el sesion errores para luego mostrarlos
	if (!empty($errores)) {
		$_SESSION['errores'] = $errores;
		header('Location: registrarse.php');
		exit;
	}
		

	$sql = "SELECT nombreusuario FROM usuarios WHERE nombreusuario = '$nombre_usuario'";
	$resultado = $conexion->query($sql);
	
	if ($resultado->num_rows == 0) {
		$sql = "INSERT INTO usuarios (nombreusuario, email, password, nombre, apellido)
						VALUES('$nombre_usuario', '$email', '$contrasenia', '$nombre', '$apellido')";

		try {
			$resultado = $conexion->query($sql);
			$_SESSION['exito'] = '<li>Te registraste con exito.</li>';
			header('Location: index.php');
		} catch(Exception $e) {
			$_SESSION['errores'] .= '<li>Error de la base de datos.</li>';
			header('Location: registrarse.php');
		}

		$_SESSION['id'] = mysqli_insert_id($conexion);
	
	} else {

		$_SESSION['errores'] .= '<li>El nombre de usuario ya existe</li>';
		header('Location: registrarse.php');
	
	}

?>