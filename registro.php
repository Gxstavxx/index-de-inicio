<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php'; 

    $tipo = $_POST['tipo'];
    $nombres = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $grado = $_POST['grado'];
    $carrera = $_POST['carrera'];
    $nickname = $_POST['nickname'];
    $correo = $_POST['correo'];
    $contra = $_POST['contraseña'];
    $contraseña = md5($_POST['contraseña']);

    if ($tipo == "alumno") {
        // Insertar en la tabla est (estudiantes)
        $sql = "INSERT INTO est (nombres, apellidos, grado, carrera, nickname, correo, contra, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssssss", $nombres, $apellidos, $grado, $carrera, $nickname, $correo, $contra, $contraseña);
            if ($stmt->execute()) {
                echo "Registro de alumno exitoso!";
            } else {
                echo "Error al registrar alumno: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta para alumno: " . $conn->error;
        }
    }

    // Cerrar la conexión
    $conn->close();
    header('Location: index.php');
    exit();
}

?>
