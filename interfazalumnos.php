<?php
session_start();
include('conexion.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Obtener el nickname del usuario logueado
$nickname = $_SESSION['user']['nickname'];

// Consulta para obtener los datos de carrera y grado del estudiante logueado
$query_est = "
    SELECT carrera, grado 
    FROM est 
    WHERE nickname = ?
    LIMIT 1
";
$stmt_est = $conn->prepare($query_est);
$stmt_est->bind_param("s", $nickname);
$stmt_est->execute();
$result_est = $stmt_est->get_result();
$row_est = $result_est->fetch_assoc();

if (!$row_est) {
    die("No se encontraron datos de carrera y grado para el estudiante logueado.");
}

$carrera_id = $row_est['carrera'];
$grado_id = $row_est['grado'];

// Consulta para obtener el nombre de la carrera
$query_carrera = "
    SELECT Carrera 
    FROM carrera 
    WHERE id = ?
    LIMIT 1
";
$stmt_carrera = $conn->prepare($query_carrera);
$stmt_carrera->bind_param("i", $carrera_id);
$stmt_carrera->execute();
$result_carrera = $stmt_carrera->get_result();
$row_carrera = $result_carrera->fetch_assoc();

if (!$row_carrera) {
    die("No se encontró el nombre de la carrera.");
}

$carrera_nombre = $row_carrera['Carrera'];

// Consulta para obtener el nombre del grado
$query_grado = "
    SELECT grado 
    FROM grado 
    WHERE id = ?
    LIMIT 1
";
$stmt_grado = $conn->prepare($query_grado);
$stmt_grado->bind_param("i", $grado_id);
$stmt_grado->execute();
$result_grado = $stmt_grado->get_result();
$row_grado = $result_grado->fetch_assoc();

if (!$row_grado) {
    die("No se encontró el nombre del grado.");
}

$grado_nombre = $row_grado['grado'];

// Consulta para obtener las materias de la tabla cursoasignado que coincidan con carrera y grado del estudiante
$query_asig = "
    SELECT Materia 
    FROM cursoasignado 
    WHERE paraqcar = ? AND paraqgra = ?
";
$stmt_asig = $conn->prepare($query_asig);
$stmt_asig->bind_param("ii", $carrera_id, $grado_id);
$stmt_asig->execute();
$result_asig = $stmt_asig->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTERFAZ PRINCIPAL DE ALUMNOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .card {
            margin-bottom: 30px;
        }
        .progress {
            height: 5px; /* Hacer la barra de progreso más delgada */
        }
        .progress-bar {
            background-color: #007bff; /* Cambiar el color de la barra de progreso */
        }
        .btn-circle {
            display: flex;
            align-items: center;
        }
        .btn-circle i {
            margin-right: 5px;
        }
        .progress-bar {
            background-color: #FF5733 !important; /* Cambiar el color de la barra de progreso */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Bienvenido, <?php echo htmlspecialchars($nickname, ENT_QUOTES, 'UTF-8'); ?>!</h2>
    <div class="row">
        <?php
        // Verificar si la consulta fue exitosa
        if (!$result_asig) {
            die("Error en la consulta: " . $stmt_asig->error);
        }

        // Iterar sobre cada asignación y mostrarla en una tarjeta
        while ($row = $result_asig->fetch_assoc()):
        ?>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="card-title m-0"><span><?php echo htmlspecialchars($row['Materia'], ENT_QUOTES, 'UTF-8'); ?></span></h4>
                        </div>
                    </div>
                </div>
                <div class="progress rounded-0">
                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="card-body">
                    <p><strong>Carrera:</strong> <?php echo htmlspecialchars($carrera_nombre, ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Grado:</strong> <?php echo htmlspecialchars($grado_nombre, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
