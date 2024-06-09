<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    include 'conexion.php'; 
    $tipo = $_POST['tipo'];
    $nombres = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $nickname = $_POST['nickname'];
    $correo = $_POST['correo'];
    $contra = ($_POST['contraseña']);
    $contraseña = md5($_POST['contraseña']);

    
    if ($tipo == "alumno") {
        $sql = "INSERT INTO est (nombres, apellidos, nickname, correo, contra, contraseña) VALUES (?, ?, ?, ?, ?, ?)";
    } else if ($tipo == "docente") {
        $sql = "INSERT INTO prof (nombres, apellidos, nickname, correo, contra, contraseña) VALUES (?, ?, ?, ?, ?, ?)";
    }

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $nombres, $apellidos, $nickname, $correo, $contra, $contraseña);
        if ($stmt->execute()) {
            echo "Registro exitoso!";
        } else {
            echo "Error al registrar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
header('Location:index.php');
?>
