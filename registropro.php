<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $nombres = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $grado = $_POST['grado'] ?? null;
    $carrera = $_POST['carrera'] ?? null;
    $materia = $_POST['materia'] ?? null;
    $nickname = $_POST['nickname'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $contra = md5('contraseña');

    $sql = "INSERT INTO prof (nombres, apellidos, grado, Carrera, Materia, nickname, correo, contra, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssss", $nombres, $apellidos, $grado, $carrera, $materia, $nickname, $correo, $contra, $contraseña);

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
}
header('Location:interfaz1.php');
?>
