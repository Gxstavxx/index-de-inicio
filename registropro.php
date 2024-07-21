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

    // Corregir el número de campos y valores en la consulta SQL
    $sql = "INSERT INTO prof (nombres, apellidos, profesion, nickname, correo, contraseña, contra) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Corregir el número de parámetros de vinculación
        $stmt->bind_param("sssssss", $nombres, $apellidos, $profesion, $nickname, $correo, $contraseña, $contra);

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
    exit(); // Asegurarse de que el script se detenga después de la redirección
}
?>

?>
