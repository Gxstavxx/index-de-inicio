<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $nickname = $_POST['nickname'];
    $correo = $_POST['correo'];
    $contra = $_POST['contraseña'];
    $contraseña = $_POST['contraseña'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE prof SET nombres='$nombre', apellidos='$apellido', nickname='$nickname', correo='$correo', contraseña='$contra', contraseña='$contraseña' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header('Location:interfaz1.php');
    } else {
        // Error al actualizar
        echo "Error al actualizar los datos: " . $conn->error;
    }

    $conn->close();
} else {
    // Redirigir si se intenta acceder directamente a este archivo sin método POST
    header("Location: editar.php?id=$id");
    exit();
}
?>
