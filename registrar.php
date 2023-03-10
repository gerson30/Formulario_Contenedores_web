<?php

//direccionamiento a registrar sesión
if (isset($_SESSION['usuario'])) {
    header('location: registrar.php');
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
    case "Agregar":

        $sentencia = $pdo->prepare("INSERT INTO tb_formularios(numero_serie,placa_vehiculo,nombre_auditor,foto_placa,foto_contenedor,foto_sello,observaciones,fecha)
                    VALUES (:numero_serie,:placa_vehiculo,:nombre_auditor,:foto_placa,:foto_contenedor,:foto_sello,:observaciones,:fecha)");

        $sentencia->bindParam(':numero_serie', $numero_serie);
        $sentencia->bindParam(':placa_vehiculo', $placa_vehiculo);
        $sentencia->bindParam(':nombre_auditor', $nombre_auditor);

        $Fecha = new DateTime();
        $nombreArchivo = ($foto_placa != "") ? $Fecha->getTimestamp() . "_" . $_FILES["foto_placa"]["name"] : "perfil.png";
        $nombreArchivo2 = ($foto_contenedor != "") ? $Fecha->getTimestamp() . "_" . $_FILES["foto_contenedor"]["name"] : "perfil.png";
        $nombreArchivo3 = ($foto_sello != "") ? $Fecha->getTimestamp() . "_" . $_FILES["foto_sello"]["name"] : "perfil.png";

        $tmpFoto_placa = $_FILES["foto_placa"]["tmp_name"];
        $tmpFoto_contenedor = $_FILES["foto_contenedor"]["tmp_name"];
        $tmpFoto_sello = $_FILES["foto_sello"]["tmp_name"];

        if ($tmpFoto_placa != "" || $tmpFoto_contenedor != "" ||  $tmpFoto_sello != "") {

            move_uploaded_file($tmpFoto_placa, "Imagenes/" . $nombreArchivo);
            move_uploaded_file($tmpFoto_contenedor, "Imagenes/" . $nombreArchivo2);
            move_uploaded_file($tmpFoto_sello, "Imagenes/" . $nombreArchivo3);
        }

        $date = new DateTime('now');
        $formatted = date('Y-m-d h:i:s a', $date->getTimestamp());

        $sentencia->bindParam(':foto_placa', $nombreArchivo);
        $sentencia->bindParam(':foto_contenedor', $nombreArchivo2);
        $sentencia->bindParam(':foto_sello', $nombreArchivo3);
        $sentencia->bindParam(':observaciones', $observaciones);
        $sentencia->bindParam(':fecha', $formatted);

        try {
            $sentencia->execute();
            echo '<script>alert(\'Registrado con éxito\')</script>';
        } catch (Exception $e) {
            echo '<script>alert(\'' . $e . '\')</script>';
        }

        //echo $radio_preg1;
        // echo "agregaste la primera pregunta";


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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilos.css">

    <!-- Custom fonts for this template-->
    <link href="sistema/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="sistema/css/sb-admin-2.min.css" rel="stylesheet">
    <title>Ingreso Contenedores</title>
    <link rel="Shortcut Icon" type="image/x-icon" href="imagenes/logo2.png">
    <style>
        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }

        .custom-file-input::before {
            content: 'Selecciona un archivo';
            display: inline-block;
            background: linear-gradient(top, #f9f9f9, #e3e3e3);
            border: 1px solid #999;
            border-radius: 3px;
            padding: 5px 8px;
            outline: none;
            white-space: nowrap;
            -webkit-user-select: none;
            cursor: pointer;
            text-shadow: 1px 1px #fff;
            font-weight: 700;
            font-size: 10pt;
        }

        .custom-file-input:hover::before {
            border-color: black;
        }

        .custom-file-input:active::before {
            background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
</head>

<body>
    <div class="shadow mb-4 ">
        <div class="p-3 container navigator justify-content-center ">
            <img class="img-fluid ml-2" id="oncor_img" src="Imagenes/imagen_oncor.png">
        </div>
    </div>

    <div class="shadow-sm mb-4">
        <div class="p-3 container navigator text-center ">
            <img style="width: 35px; height: 35px;" class="img-fluid ml-2" id="oncor_img" src="Imagenes/perfil.png">
            <?php echo $_SESSION['nombre'];           ?>
        </div>
    </div>

    

    <div class="formulario container mt-5">
        <div class="d-flex justify-content-center">
            <div class="encabezado">

				<div class="d-flex justify-content-around">
						<div class="d-flex justify-content-center">
							<a href="registrar.php" class="btn btn-secondary">Registrar </a>
						</div>

						<?php if ($_SESSION['rol'] == 1) { ?>
							<div class="d-flex justify-content-center ">
								<a href="lista.php" class="btn btn-secondary">Lista </a>
							</div>
						<?php } ?>

						<div class="d-flex justify-content-center">
							<a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
						</div>
					</div>
				<br>



                <h4 class="title">Monitoreo Ingreso Contenedores </h4><br>
                <h5 id="preg1-1" class="text-center">Barranquilla</h5><br>
            </div>
        </div>
        <hr>
        <form action="" method="POST" enctype="multipart/form-data">

            <div class="d-flex justify-content-center">

                <div>
                    <div class="pregunta1-1 col-md-12">
                        <h5>Número de serie<span style="color: red;">*</span></h5>
                        <input class="form-control" type="text" name="numero_serie" id="diligente" placeholder="indique N| Serie" required>
                    </div>
                </div>

                <div>
                    <div class="pregunta1-1 col-md-12 ">
                        <h5>Placa vehículo<span style="color: red;">*</span></h5>
                        <input class="form-control" type="text" name="placa_vehiculo" id="diligente" placeholder="Indique placa vehículo" required>
                    </div>
                </div>




            </div>

            <div class="d-flex justify-content-center mt-4 mb-4">
                <div class="row">


                    <div class="col-lg-4 col-sm-12 btn-dark" id="add-photo-container">
                        <div class="add-new-photo first" id="add-photo">
                            <label for="">Foto Placa</label>
                            <span><i class="icon-camera"></i></span>
                        </div>
                        <input name="foto_placa" id="foto_placa" type="file" accept="image/*">
                    </div>

                    <div class="col-lg-4 col-sm-12 btn-dark" id="add-photo-container">
                        <div class="add-new-photo first" id="add-photo">
                            <label for="">Foto Contenedor</label>
                            <span><i class="icon-camera"></i></span>
                        </div>
                        <input name="foto_contenedor" id="foto_contenedor" type="file" accept="image/*">
                    </div>

                    <div class="col-lg-4 col-sm-12 btn-dark" id="add-photo-container">
                        <div class="add-new-photo first" id="add-photo">
                            <label for="">Foto Sello</label>
                            <span><i class="icon-camera"></i></span>
                        </div>
                        <input name="foto_sello" id="foto_sello" type="file" accept="image/*">
                    </div>
                </div>
            </div>


            <div class="d-flex justify-content-center">
                <input name="nombre_auditor" required type="text" value="<?php echo $_SESSION['usuario']; ?>" hidden>
            </div>


            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <textarea class="observaciones form-control" cols="10" name="observaciones" placeholder="Observaciones" required></textarea>
                </div>
            </div>

            <input type="hidden" name="registro_id" value="0">

            <div class="container_button">
                <input class="btn-enviar" id="Agregar" type="submit" value="Agregar" name="accion">
            </div>

            <hr>
            <br>
            <br>
            <!-- <input class="btn-enviar" id="Modificar" type="submit" value="Modificar" name="accion"> -->
        </form>
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

</html>