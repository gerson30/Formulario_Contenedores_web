<?php

include('conexion/conexion.php');


$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

$conexion = mysqli_connect("localhost", "root", "", "contenedores_form");

$consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contraseña'";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_num_rows($resultado);

if ($filas) {
	
	session_start();
	$_SESSION['usuario'] = $usuario;
	if ($resultado) {
    $rol = $resultado->fetch_object();
    $_SESSION['rol'] = $rol->admin;
        $_SESSION['usuario'] = $rol->usuario;
	}
   
    $_SESSION['nombre'] = $rol->Nombre;

    header("location:registrar.php");
} else {

    echo '<script>alert(\'Las credenciales ingresadas son incorrectas\')</script>';
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; url=login.php'>";

    // header('location:login.php');
}


mysqli_free_result($resultado);
mysqli_close($conexion);