<?php
session_start(); // Inicia la sesión para manejar mensajes

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

    // Verificar si el nickname ya existe
    $sql_check = "SELECT COUNT(*) AS count FROM est WHERE nickname = ?";
    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param("s", $nickname);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count > 0) {
            $_SESSION['error_message'] = "El nickname ya está en uso, elija otro.";
            $_SESSION['form_data'] = $_POST; // Guarda los datos del formulario para mostrar de nuevo
            header('Location: registrar.php');
            exit();
        } else {
            // Insertar en la tabla est (estudiantes)
            $sql = "INSERT INTO est (nombres, apellidos, grado, carrera, nickname, correo, contra, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssssssss", $nombres, $apellidos, $grado, $carrera, $nickname, $correo, $contra, $contraseña);
                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Registro de alumno exitoso!";
                    header('Location: regialum.php');
                    exit();
                } else {
                    $_SESSION['error_message'] = "Error al registrar alumno: " . $stmt->error;
                    $_SESSION['form_data'] = $_POST; // Guarda los datos del formulario para mostrar de nuevo
                    header('Location: registrar.php');
                    exit();
                }
                $stmt->close();
            } else {
                $_SESSION['error_message'] = "Error al preparar la consulta para alumno: " . $conn->error;
                $_SESSION['form_data'] = $_POST; // Guarda los datos del formulario para mostrar de nuevo
                header('Location: registrar.php');
                exit();
            }
        }
    }

    // Cerrar la conexión
    $conn->close();
}
?>
