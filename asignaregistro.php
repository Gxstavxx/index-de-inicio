<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $profesor_id = $_POST['profesor_id'];
    $nombres = $_POST['nombres']; // Ajusta según el nombre del campo en tu formulario
    $apellidos = $_POST['apellidos']; // Ajusta según el nombre del campo en tu formulario
    $grado = $_POST['grado'];
    $carrera = $_POST['carrera'];
    $materia = $_POST['materia'];

    $sql = "INSERT INTO asig (nombres, apellidos, grado, Carrera, Materia) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $nombres, $apellidos, $grado, $carrera, $materia);

        if ($stmt->execute()) {
            echo "Asignatura agregada correctamente!";
            // Redirigir a asignatura.php después de la inserción
            header('Location: asignatura.php');
            exit;
        } else {
            echo "Error al agregar asignatura: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    $conn->close();
}
?>
