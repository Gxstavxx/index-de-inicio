<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conexion.php';

    $nickname = $_POST['nickname'];
    $correo = $_POST['correo'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $nueva_contrasena_hashed = md5($nueva_contrasena); // Puedes usar otra función de hash más segura como password_hash

    $tipo = $_POST['tipo'];

    if ($tipo == 'alumno') {
        $sql = "UPDATE est SET contra='$nueva_contrasena', contraseña='$nueva_contrasena_hashed' WHERE nickname='$nickname' AND correo='$correo'";
    } else if ($tipo == 'docente') {
        $sql = "UPDATE prof SET contra='$nueva_contrasena', contraseña='$nueva_contrasena_hashed' WHERE nickname='$nickname' AND correo='$correo'";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?message=Contraseña actualizada con éxito");
        exit();
    } else {
        echo "Error al actualizar la contraseña: " . $conn->error;
    }

    $conn->close();
}
?>
