<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    // Obtén los valores del formulario
    $curso = $_POST['curso'];
    $carrera_id = $_POST['carrera'];
    $grado_id = $_POST['grado'];

    // Obtener el nombre de la carrera y el grado desde sus respectivas tablas
    $query_carrera = "SELECT Carrera FROM carrera WHERE id = ?";
    $query_grado = "SELECT grado FROM grado WHERE id = ?";

    // Consultar nombre de la carrera
    if ($stmt_carrera = $conn->prepare($query_carrera)) {
        $stmt_carrera->bind_param("i", $carrera_id);
        $stmt_carrera->execute();
        $stmt_carrera->bind_result($nombre_carrera);
        $stmt_carrera->fetch();
        $stmt_carrera->close();
    } else {
        echo "Error al preparar la consulta de carrera: " . $conn->error;
        exit();
    }

    // Consultar nombre del grado
    if ($stmt_grado = $conn->prepare($query_grado)) {
        $stmt_grado->bind_param("i", $grado_id);
        $stmt_grado->execute();
        $stmt_grado->bind_result($nombre_grado);
        $stmt_grado->fetch();
        $stmt_grado->close();
    } else {
        echo "Error al preparar la consulta de grado: " . $conn->error;
        exit();
    }

    // Verificar si ya existe la combinación Materia, Carrera, Grado
    $query_check = "SELECT COUNT(*) FROM cursoasignado WHERE Materia = ? AND paraqcar = ? AND paraqgra = ?";
    if ($stmt_check = $conn->prepare($query_check)) {
        $stmt_check->bind_param("sss", $curso, $nombre_carrera, $nombre_grado);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count > 0) {
            $errorMsg = "La materia ya está asignada a esta carrera y grado.";
            include 'regicursos.php'; // Incluir el formulario con el mensaje de error
            exit();
        }
    } else {
        echo "Error al preparar la consulta de verificación: " . $conn->error;
        exit();
    }

    // Insertar en la tabla CursoAsignado si no existe
    $sql = "INSERT INTO cursoasignado (Materia, paraqcar, paraqgra) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $curso, $nombre_carrera, $nombre_grado);
        if ($stmt->execute()) {
            header('Location: Cursos.php');
            exit();
        } else {
            echo "Error al registrar curso asignado: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta de inserción: " . $conn->error;
    }

    $conn->close();
}
?>
