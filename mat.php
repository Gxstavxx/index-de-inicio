<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $carrera = $_POST['carrera'];
    $grado = $_POST['grado'];
    $materia = $_POST['materia'];

    $sql = "INSERT INTO mat (grado, Carrera, Materia) VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $grado, $carrera, $materia);

        if ($stmt->execute()) {
            echo "Registro exitoso!";
        } else {
            echo "Error al registrar: " . $stmt->error;
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
