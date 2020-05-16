<?php 
include 'db.php';
$conexion = conectar();

$id = $_GET['id'];

// se recupera la información de la imagen
$sql = "SELECT contenidoimagen, tipoimagen FROM peliculas WHERE id = $id"; 

$result = mysqli_query($conexion, $sql); 
$row = mysqli_fetch_array($result); 
mysqli_close($conexion); 

// se imprime la imagen y se le avisa al navegador que lo que se está 
// enviando no es texto, sino que es una imagen de un tipo en particular
header("Content-type:"  . $row['tipoimagen']);
echo $row['contenidoimagen'];
