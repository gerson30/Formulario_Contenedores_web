<?php
header('Content-Encoding: UTF-8');
header("Content-Type: application/xls; charset=UTF-8'");
header("Content-Disposition: attachment; filename= reporte.xls");
echo "\xEF\xBB\xBF";

?>

<?php

$id = (isset($_POST['id'])) ? $_POST['id'] : "";
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : "";
$numero_serie = (isset($_POST['numero_serie'])) ? $_POST['radio_preg2'] : "";
$placa_vehiculo = (isset($_POST['placa_vehiculo'])) ? $_POST['placa_vehiculo'] : "";
$nombre_auditor = (isset($_POST['nombre_auditor'])) ? $_POST['nombre_auditor'] : "";
$foto_placa = (isset($_FILES['foto_placa']["name"])) ? $_FILES['foto_placa']["name"] : "";
$foto_contenedor = (isset($_FILES['foto_contenedor']["name"])) ? $_FILES['foto_contenedor']["name"] : "";
$foto_sello = (isset($_FILES['foto_sello']["name"])) ? $_FILES['foto_sello']["name"] : "";
$observaciones = (isset($_POST['observaciones'])) ? $_POST['observaciones'] : "";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include('conexion/conexion.php');




$sentencia = $pdo->prepare("SELECT * FROM `tb_formularios` WHERE 1");
$sentencia->execute();
$listaFormulario = $sentencia->fetchAll(PDO::FETCH_ASSOC); //ASIGNAR LISTA A LA VARIABLE $listaFormulario



?>

<table class="table table-hover">

    <thead>
        <tr>
            <th class="align-middle">Fecha</th>
            <th class="align-middle">Foto placa</th>
            <th class="align-middle">Foto contenedor </th>
            <th class="align-middle">foto sello</th>
            <th class="align-middle">Número de serie</th>
            <th class="align-middle">Placa vehículo</th>
            <th class="align-middle">Nombre auditor</th>
            <th class="align-middle">Observaciones</th>
        </tr>
    </thead>
    <?php foreach ($listaFormulario as $fomulario) { ?>
        <tr>
            <td><?php echo $fomulario['fecha']; ?></td>
            <td><?php echo $_SERVER['HTTP_HOST']; ?>/formulario_contenedores/Imagenes/<?php echo $fomulario['foto_placa']; ?></td>
            <td><?php echo $_SERVER['HTTP_HOST']; ?>/formulario_contenedores/Imagenes/<?php echo $fomulario['foto_contenedor']; ?></td>
            <td><?php echo $_SERVER['HTTP_HOST']; ?>/formulario_contenedores/Imagenes/<?php echo $fomulario['foto_sello']; ?></td>
			<td><?php echo $fomulario['numero_serie']; ?></td>
            <td><?php echo $fomulario['placa_vehiculo']; ?></td>
            <td><?php echo $fomulario['nombre_auditor']; ?></td>
            <td><?php echo $fomulario['observaciones']; ?></td>

        </tr>
    <?php } ?>
</table>