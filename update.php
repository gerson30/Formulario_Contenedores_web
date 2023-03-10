<?php

include('conexion/conexion.php');

$conexion = mysqli_connect("localhost", "root", "", "contenedores_form");

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM tb_formularios WHERE id = $id";
    $result = mysqli_query($conexion, $query);
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $fecha = $row['fecha'];
        echo $fecha;
    }
}
?>
