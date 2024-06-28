<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $nombres = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $nickname = $_POST['nickname'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $contra = md5($contraseña);

    $sql = "INSERT INTO prof (nombres, apellidos, nickname, correo, contraseña, contra) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $nombres, $apellidos, $nickname, $correo, $contraseña, $contra);

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
    header('Location: interfaz1.php');
}
?>
