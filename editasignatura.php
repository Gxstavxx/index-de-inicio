<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $grado = $_POST['grado'];
    $carrera = $_POST['carrera'];
    $materia = $_POST['materia'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE asig SET nombres=?, apellidos=?, grado=?, Carrera=?, Materia=? WHERE id=?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssi", $nombres, $apellidos, $grado, $carrera, $materia, $id);

        if ($stmt->execute()) {
            // Redirigir a asignatura.php después de la actualización exitosa
            header('Location: asignatura.php');
            exit;
        } else {
            // Error al ejecutar la consulta
            echo "Error al actualizar la asignatura: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Error al preparar la consulta
        echo "Error al preparar la consulta: " . $conn->error;
    }

    $conn->close();
} else {
    // Redirigir si se intenta acceder directamente a este archivo sin método POST
    header("Location: editar.php?id=$id");
    exit();
}
?>
