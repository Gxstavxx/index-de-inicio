<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $nombres = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $profesion = $_POST['profesion'];
    $nickname = $_POST['nickname'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $contra = md5($contraseña);

    // Verificar si el nickname ya existe
    $check_sql = "SELECT * FROM prof WHERE nickname = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $nickname);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // El nickname ya existe
        $errorMsg = "El usuario ya existe. Por favor, elija otro.";
        include 'registrarpro.php'; // Asegúrate de que 'registro_form.php' contiene el código HTML del formulario
    } else {
        // Insertar nuevo registro
        $sql = "INSERT INTO prof (nombres, apellidos, profesion, nickname, correo, contraseña, contra) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $nombres, $apellidos, $profesion, $nickname, $correo, $contraseña, $contra);

        if ($stmt->execute()) {
            header('Location: interfaz1.php');
            exit(); // Asegurarse de que el script se detenga después de la redirección
        } else {
            $errorMsg = "Error al registrar: " . $stmt->error;
            include 'registro_form.php';
        }

        $stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>
