<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    header('location: login.php');
}


ob_start();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>


    <?php

    include('conexion/conexion.php');

    $sentencia = $pdo->prepare("SELECT * FROM `tb_formularios` WHERE 1");
    $sentencia->execute();
    $listaFormulario = $sentencia->fetchAll(PDO::FETCH_ASSOC); //ASIGNAR LISTA A LA VARIABLE $listaFormulario

	if (isset($_GET["id"]) && isset($_GET["fd"])) {
    $sentencia = $pdo->prepare("SELECT * FROM `tb_formularios` WHERE fecha BETWEEN '" . $_GET["id"] . "' AND '" . $_GET["fd"] . "'");
    $sentencia->execute();
    $listaFormulario = $sentencia->fetchAll(PDO::FETCH_ASSOC); //ASIGNAR LISTA A LA VARIABLE $listaFormulario
}
    ?>


    <h1>Reporte de Formulario - Inspecciones Ambientales</h1>

    <table class="table table-hover">

        <thead>
            <tr>
                <th>Fecha</th>
                <th>foto Placa</th>
                <th>foto Contenedor</th>
                <th>foto Sello</th>
                <th class="align-middle">Numero Serie</th>
                <th class="align-middle">Placa Vehículo</th>
                <th class="align-middle">Nombre Auditor</th>
                <th class="align-middle">Observaciones</th>

            </tr>
        </thead>
        <?php foreach ($listaFormulario as $fomulario) { ?>
            <tr>
                <td><?php echo $fomulario['fecha']; ?></td>
                <td><img class="" width="100px" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/formulario_contenedores/Imagenes/<?php echo $fomulario['foto_placa']; ?>"  alt="" srcset="" /> </td>
                <td><img class="" width="100px" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/formulario_contenedores/Imagenes/<?php echo $fomulario['foto_contenedor']; ?>"  alt="" srcset="" /> </td>
                <td><img class="" width="100px" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/formulario_contenedores/Imagenes/<?php echo $fomulario['foto_sello']; ?>"  alt="" srcset="" /> </td>
                <td><?php echo $fomulario['numero_serie']; ?></td>
                <td><?php echo $fomulario['placa_vehiculo']; ?></td>
                <td><?php echo $fomulario['nombre_auditor']; ?></td>
                <td><?php echo $fomulario['observaciones']; ?></td>

            </tr>
        <?php } ?>
    </table>

</body>

</html>

<?php

$html = ob_get_clean();
//echo $html;

require_once 'libreria/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->load_Html($html);
//$dompdf->setPaper('letter');

//$dompdf->setPaper('A4', 'landscape');

$paper_size = array(0, 0, 1660, 860);
$dompdf->set_paper($paper_size);


$dompdf->render();

$dompdf->stream("reporte.pdf", array("Attachment" => false));


?>