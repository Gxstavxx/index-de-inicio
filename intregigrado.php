<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php'; 

    $carrera = $_POST['carrera'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO Carrera (carrera, descripcion) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $carrera, $descripcion);
        if ($stmt->execute()) {
            echo "Registro de carrera exitoso!";
        } else {
            echo "Error al registrar carrera: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    $conn->close();
    header('Location: asignatura.php');
    exit();
}
?>