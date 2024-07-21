<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    // Obtén los valores del formulario
    $curso = $_POST['curso'];
    $carrera_id = $_POST['carrera'];
    $grado_id = $_POST['grado'];

    // Obtener el nombre de la carrera y el grado desde sus respectivas tablas
    $query_carrera = "SELECT Carrera FROM Carrera WHERE id = ?";
    $query_grado = "SELECT grado FROM Grado WHERE id = ?";

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

    // Insertar en la tabla CursoAsignado
    $sql = "INSERT INTO CursoAsignado (Docente, Materia, paraqcar, paraqgra) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $docente = ''; // Puedes obtenerlo de alguna otra forma si es necesario
        $stmt->bind_param("ssss", $docente, $curso, $nombre_carrera, $nombre_grado);
        if ($stmt->execute()) {
            echo "Registro de curso asignado exitoso!";
        } else {
            echo "Error al registrar curso asignado: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta de inserción: " . $conn->error;
    }

    $conn->close();
    header('Location: Cursos.php');
    exit();
}
?>
