<?php

if (isset($_SESSION['usuario'])) {
    header('location: login.php');
}


date_default_timezone_set('America/Bogota');

$id = (isset($_POST['id'])) ? $_POST['id'] : "";
$numero_serie = (isset($_POST['numero_serie'])) ? $_POST['numero_serie'] : "";
$placa_vehiculo = (isset($_POST['placa_vehiculo'])) ? $_POST['placa_vehiculo'] : "";
$foto_placa = (isset($_FILES['foto_placa']["name"])) ? $_FILES['foto_placa']["name"] : "";
$foto_contenedor = (isset($_FILES['foto_contenedor']["name"])) ? $_FILES['foto_contenedor']["name"] : "";
$foto_sello = (isset($_FILES['foto_sello']["name"])) ? $_FILES['foto_sello']["name"] : "";
$nombre_auditor = (isset($_POST['nombre_auditor'])) ? $_POST['nombre_auditor'] : "";
$observaciones = (isset($_POST['observaciones'])) ? $_POST['observaciones'] : "";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include('conexion/conexion.php');

session_start();
switch ($accion) {

    /*case "Editar":

        echo "presionaste el boton modificar";

        $sentencia = $pdo->prepare("UPDATE tb_formularios SET numero_serie=:numero_serie,
        placa_vehiculo=:placa_vehiculo,
        nombre_auditor=:nombre_auditor,        
        observaciones=:observaciones WHERE id=:id");


        $sentencia->bindParam(':numero_serie', $numero_serie);
        $sentencia->bindParam(':placa_vehiculo', $placa_vehiculo);
        $sentencia->bindParam(':nombre_auditor', $nombre_auditor);
        $sentencia->bindParam(':observaciones', $observaciones);
        $sentencia->bindParam(':id', $id);

        $sentencia->execute();

        $Fecha = new DateTime();
        $nombreArchivo = ($foto_placa != "") ? $Fecha->getTimestamp() . "_" . $_FILES["foto_placa"]["name"] : "perfil.png";
        $nombreArchivo2 = ($foto_contenedor != "") ? $Fecha->getTimestamp() . "_" . $_FILES["foto_contenedor"]["name"] : "perfil.png";
        $nombreArchivo3 = ($foto_sello != "") ? $Fecha->getTimestamp() . "_" . $_FILES["foto_sello"]["name"] : "perfil.png";

        $tmpFoto = $_FILES["foto_placa"]["tmp_name"];
        $tmpFoto2 = $_FILES["foto_contenedor"]["tmp_name"];
        $tmpFoto3 = $_FILES["foto_sello"]["tmp_name"];

        if ($tmpFoto_placa != "" || $tmpFoto_contenedor != "" ||  $tmpFoto_sello != "") {

            move_uploaded_file($tmpFoto_placa, "Imagenes/" . $nombreArchivo);
            move_uploaded_file($tmpFoto_contenedor, "Imagenes/" . $nombreArchivo2);
            move_uploaded_file($tmpFoto_sello, "Imagenes/" . $nombreArchivo3);

            $sentencia = $pdo->prepare("UPDATE tb_formularios SET foto1=:foto1,
            foto2=:foto2,
            foto3=:foto3 WHERE id=:id");

            $sentencia->bindParam(':foto_placa', $nombreArchivo);
            $sentencia->bindParam(':foto_contenedor', $nombreArchivo2);
            $sentencia->bindParam(':foto_sello', $nombreArchivo3);
            $sentencia->bindParam(':id', $nombreArchivo3);/*Variable duplicada 

            $sentencia->execute();
        }
        header('Location: lista.php');
        break;

        */

    case "Eliminar":
        try {
            $sentencia = $pdo->prepare("SELECT foto_placa,foto_contenedor,foto_sello from tb_formularios WHERE id=:id");
            $sentencia->bindParam(':id', $id);
            $sentencia->execute();
            $formulario = $sentencia->fetch(PDO::FETCH_LAZY);


            if (isset($formulario["foto_placa"])) {
                if (file_exists("Imagenes/" . $formulario["foto_placa"])) {
                    unlink("Imagenes/" . $formulario["foto_placa"]);
                }
            }

            if (isset($formulario["foto_contenedor"])) {
                if (file_exists("Imagenes/" . $formulario["foto_contenedor"])) {
                    unlink("Imagenes/" . $formulario["foto_contenedor"]);
                }
            }

            if (isset($formulario["foto_sello"])) {
                if (file_exists("Imagenes/" . $formulario["foto_sello"])) {
                    unlink("Imagenes/" . $formulario["foto_sello"]);
                }
            }

            $sentencia = $pdo->prepare("DELETE FROM tb_formularios WHERE id=:id");
            $sentencia->bindParam(':id', $id);
            $sentencia->execute();

        }catch(Exception $e){
            echo "<script>console.log('prueba')</script>  harold te amo";
            
        }
        break;
}


$sentencia = $pdo->prepare("SELECT * FROM `tb_formularios` WHERE 1");
$sentencia->execute();
$listaFormulario = $sentencia->fetchAll(PDO::FETCH_ASSOC); //ASIGNAR LISTA A LA VARIABLE $listaFormulario

if (isset($_GET["id"]) && isset($_GET["fd"])) {
    $sentencia = $pdo->prepare("SELECT * FROM `tb_formularios` WHERE fecha BETWEEN '" . $_GET["id"] . "' AND '" . $_GET["fd"] . "'");
    $sentencia->execute();
    $listaFormulario = $sentencia->fetchAll(PDO::FETCH_ASSOC); //ASIGNAR LISTA A LA VARIABLE $listaFormulario
}

//print_r($listaFormulario);


?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <title>Ingreso Contenedores </title>
    <link rel="Shortcut Icon" type="image/x-icon" href="imagenes/logo2.png">
</head>

<body class="shadow mb-4">

    <div class="shadow mb-4 ">
        <div class="p-3 container navigator justify-content-center ">
            <img class="img-fluid ml-2" id="oncor_img" src="Imagenes/imagen_oncor.png">
        </div>
    </div>

    <div class="shadow-sm mb-4">
        <div class="p-3 container navigator0 text-center ">
            <img style="width: 35px; height: 35px;" class="img-fluid ml-2" id="oncor_img" src="Imagenes/perfil.png">
            <?php echo $_SESSION['nombre'];           ?>
        </div>

    </div>


    <div class="formulario container mt-5">
	
		<div class="d-flex justify-content-around pt-4">
        <div class="d-flex justify-content-center ">
            <a href="registrar.php" class="btn btn-secondary">Registrar </a>
        </div>

        <div class="d-flex justify-content-center ">
            <a href="lista.php" class="btn btn-secondary">Lista </a>

        </div>

        <div class="d-flex justify-content-center">
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>

        <?php if ($_SESSION['rol'] == 1) { ?>
            <div class="container">
                <br>
                <br>
                <br>
                <form class="row">
                    <div class="col-lg-2">
                        <label>Fecha Inicial</label>
                        <input name="id" type="date" class="form-control">
                    </div>
                    <div class="col-lg-2">
                        <label>Fecha Final</label>
                        <input name="fd" type="date" class="form-control">
                    </div>
                    <div class="col-lg-2">
                        <?php if (!(isset($_GET["id"]) && isset($_GET["fd"]))) { ?>
                            <label> </label>
                        <?php } ?>
                        <input type="submit" class="form-control btn btn-success " value="Filtrar">
                        <?php if (isset($_GET["id"]) && isset($_GET["fd"])) { ?>
                            <a class="form-control btn btn-danger mt-1" href="lista.php">Quitar Filtros</a>
                        <?php } ?>
                    </div>
                </form>
                <hr>
            </div>
            <div>
                <div style="margin-left:5%; margin-right:5%; ">
                    <div class="table-responsive mt-4 pb-2  ">
                        <table id="dataTable" class="table table-hover table-bordered">
                            <thead>
                                <tr class="bg-oncor text-light">
                                    <th class="align-middle">Fecha</th>
                                    <th class="align-middle">Foto Placa</th>
                                    <th class="align-middle">Foto Contenedor</th>
                                    <th class="align-middle">Foto Sello</th>
                                    <th class="align-middle">Número de serie</th>
                                    <th class="align-middle">Placa Vehículo</th>
                                    <th class="align-middle">Nombre Auditor</th>
                                    <th class="align-middle">Observaciones</th>
                                    <th class="align-middle">Eliminar</th>
                                    <!-- <th class="align-middle">Editar</th> -->
                                </tr>
                            </thead>
                            <?php foreach ($listaFormulario as $fomulario) { ?>
                                <tr>
                                    <td><?php echo explode('.', $fomulario['fecha'])[0]; ?></td>
                                    <td><a href="Imagenes/<?php echo $fomulario['foto_placa']; ?>"><img class="img-thumbnail" width="100px" src="Imagenes/<?php echo $fomulario['foto_placa']; ?>" /></a></td>
                                    <td><a href="Imagenes/<?php echo $fomulario['foto_contenedor']; ?>"><img class="img-thumbnail" width="100px" src="Imagenes/<?php echo $fomulario['foto_contenedor']; ?>" /></a></td>
                                    <td><a href="Imagenes/<?php echo $fomulario['foto_sello']; ?>"><img class="img-thumbnail" width="100px" src="Imagenes/<?php echo $fomulario['foto_sello']; ?>" /></a></td>
                                    <td><?php echo $fomulario['numero_serie']; ?></td>
                                    <td><?php echo $fomulario['placa_vehiculo']; ?></td>
                                    <td><?php echo $fomulario['nombre_auditor']; ?></td>
                                    <td><?php echo $fomulario['observaciones']; ?></td>
                                    <td>
                                        <form action="" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $fomulario['id']; ?>">
                                            <button value="Eliminar" class="btn btn-danger" type="submit" name="accion" onclick="return Confirmar('¿ Esta seguro que desea eliminar el registro ?');">Eliminar</button>
                                        </form>
                                    </td>
                                    <!--
                                    <td>
                                        <form action="" >  
                                            <a href="update.php?id= " class="btn btn-secondary">Editar </a>
                                        </form>
                                    </td>
                                    -->
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="container_button pb-4" style="display: flex; justify-content:center;">
                    <?php if (!(isset($_GET["id"]) && isset($_GET["fd"]))) { ?>
                       <!-- <a class="btn btn-success" href="excel.php" style="margin-right: 10px;">Descargar en Excel</a>-->
                    <?php } ?>
                    <?php if (isset($_GET["id"]) && isset($_GET["fd"])) { ?>
                        <a class="btn btn-success" href="<?php echo 'excel.php?id=' . $_GET['id'] . '&fd=' . $_GET['fd'] ?>" style="margin-right: 10px;">Descargar en Excel</a>
                    <?php } ?>

                    <div class="row_button">
                        <?php if (!(isset($_GET["id"]) && isset($_GET["fd"]))) { ?>
                            <a class="btn btn-danger" href="reportes_pdf.php" style="margin-right: 10px;">Descargar en PDF</a>
                        <?php } ?>
                        <?php if (isset($_GET["id"]) && isset($_GET["fd"])) { ?>
                            <a class="btn btn-danger" href="<?php echo 'reportes_pdf.php?id=' . $_GET['id'] . '&fd=' . $_GET['fd'] ?>" style="margin-right: 10px;">Descargar en PDF</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "lengthMenu": "Ver _MENU_ registros",
                    "zeroRecords": "Sin registros",
                    "info": "Viendo la página _PAGE_ de _PAGES_",
                    "infoEmpty": "Sin registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros.)",
                    "search": "Buscar:",
                    "pageLength": {
                        "-1": "Mostrar todas las filas",
                        "_": "Mostrar %d filas"
                    },
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                }
            });
        });
    </script>
    <script>
        function Confirmar(Mensaje) {
            return (confirm(Mensaje)) ? true : false;
        }
    </script>


</body>

</html>'