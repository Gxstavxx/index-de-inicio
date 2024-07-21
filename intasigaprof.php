<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php'; 

    // Obtén los valores del formulario
    $curso = $_POST['curso'];
    $descripcion = $_POST['desc'];

    // Inserta en la tabla curso
    $sql = "INSERT INTO Curso (Materia, Descripcion) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $curso, $descripcion);
        if ($stmt->execute()) {
            echo "Registro de curso exitoso!";
        } else {
            echo "Error al registrar curso: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    $conn->close();
    header('Location: Cursos.php');
    exit();
}
?>
