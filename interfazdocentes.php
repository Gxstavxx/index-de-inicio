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

// Consulta para obtener todas las asignaciones de cursos del docente logueado con nombres de carrera, grado y materia
$query_asig = "
    SELECT 
        ca.id, 
        ca.Docente, 
        ca.Profesion AS Profesion,
        ca.nickname,
        c.Carrera AS paraqcar,
        g.grado AS paraqgra,
        cu.Materia AS cursig
    FROM cursoasig ca
    LEFT JOIN Carrera c ON ca.paraqcar = c.id
    LEFT JOIN Grado g ON ca.paraqgra = g.id
    LEFT JOIN CursoAsignado cu ON ca.cursig = cu.id
    WHERE ca.nickname = ?
"; 
$stmt = $conn->prepare($query_asig);
$stmt->bind_param("s", $nickname);
$stmt->execute();
$result_asig = $stmt->get_result();

// Obtener el nombre del docente para el mensaje de bienvenida
$query_docente = "
    SELECT Docente 
    FROM cursoasig 
    WHERE nickname = ?
    LIMIT 1
";
$stmt_docente = $conn->prepare($query_docente);
$stmt_docente->bind_param("s", $nickname);
$stmt_docente->execute();
$result_docente = $stmt_docente->get_result();
$row_docente = $result_docente->fetch_assoc();
$docente_name = $row_docente['Docente'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTERFAZ PRINCIPAL DE DOCENTES</title>
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
    <h2 class="mb-4">Bienvenido, <?php echo htmlspecialchars($docente_name, ENT_QUOTES, 'UTF-8'); ?>!</h2>
    <div class="row">
        <?php
        // Verificar si la consulta fue exitosa
        if (!$result_asig) {
            die("Error en la consulta: " . mysqli_error($conn));
        }

        // Iterar sobre cada asignación y mostrarla en una tarjeta
        while ($row = $result_asig->fetch_assoc()):
        ?>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="card-title m-0"><span><?php echo htmlspecialchars($row['paraqcar'], ENT_QUOTES, 'UTF-8'); ?></span></h4>
                        </div>
                    </div>
                </div>
                <div class="progress rounded-0">
                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="card-body">
                    <p><strong>Grado:</strong> <?php echo htmlspecialchars($row['paraqgra'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Materia:</strong> <?php echo htmlspecialchars($row['cursig'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div style="margin: 6px 6px 6px 80%;" id="divBtnVerCursos4117">
                    <a href="asignatura.php?carrera=<?php echo $row['paraqcar']; ?>" class="btn btn-info btn-circle">
                        <i class="material-icons">Notas</i>
                    </a>
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
