<?php
include 'conexion.php';

// Manejar la acción del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $search = $_POST['search']; // Nombre completo del profesor ingresado
    $materia = $_POST['materia']; // Materia asignada
    $descripcion = $_POST['des']; // Descripción de la materia asignada

    // Insertar en la tabla CursoAsignado
    $sql = "INSERT INTO CursoAsignado (Docente, Materia, Descripcion) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $search, $materia, $descripcion);
        if ($stmt->execute()) {
            // Redirigir a asigprof.php después de la inserción exitosa
            header('Location: asigprof.php');
            exit();
        } else {
            echo "Error al registrar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    $conn->close();
}
?>
