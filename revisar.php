<?php

include 'conexion.php';

$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

$query_adm = "SELECT * FROM adm WHERE correo='$correo' AND contraseña='$contraseña'";
$result_adm = mysqli_query($conn, $query_adm);

if (mysqli_num_rows($result_adm) > 0) {
    $_SESSION['user'] = mysqli_fetch_assoc($result_adm);
    header("Location: interfaz.php");
    exit();
}

$query_prof = "SELECT * FROM prof WHERE correo='$correo' AND contraseña='$contraseña'";
$result_prof = mysqli_query($conn, $query_prof);

if (mysqli_num_rows($result_prof) > 0) {
    $_SESSION['user'] = mysqli_fetch_assoc($result_prof);
    header("Location: interfaz2.php");
    exit();
}

$query_est = "SELECT * FROM est WHERE correo='$correo' AND contraseña='$contraseña'";
$result_est = mysqli_query($conn, $query_est);

if (mysqli_num_rows($result_est) > 0) {
    $_SESSION['user'] = mysqli_fetch_assoc($result_est);
    header("Location: interfaz3.php");
    exit();
}

header("Location: index.php?error=Usuario o contraseña incorrectos");
exit();
?>
