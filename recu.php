<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "conexion.php";

    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $new_password_hashed = md5($new_password);

    // Actualizar la contraseña en la base de datos
    $sql = "UPDATE s SET contra='$new_password', contraseña='$new_password_hashed' WHERE nickname='$nickname' AND correo='$email'";
    if (mysqli_query($conn, $sql)) {
        // Redirigir a index.php después de actualizar la contraseña
        header("Location: index.php?message=Contraseña actualizada con éxito");
        exit();
    } else {
        echo "Error al actualizar la contraseña.";
    }
}
?>

