<?php
session_start();
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['nickname'];
    $contraseña = md5($_POST['contraseña']); // Convertir la contraseña a MD5 para compararla

    // Consulta para verificar si es administrador
    $admins = array(
        array("nickname" => "gustavo-admin", "contraseña" => md5("38331665")),
        array("nickname" => "lizardo-admin", "contraseña" => md5("48913484"))
    );

    function verificarCredenciales($nickname, $contraseña, $admins) {
        foreach ($admins as $admin) {
            if ($admin['nickname'] === $nickname && $admin['contraseña'] === $contraseña) {
                return true;
            }
        }
        return false;
    }

    if (verificarCredenciales($nickname, $contraseña, $admins)) {
        $_SESSION['user'] = array("nickname" => $nickname);
        header("Location: interfazprincipal.php");
        exit();
    }

    // Consulta para verificar si es profesor
    $query_prof = "SELECT * FROM prof WHERE nickname=? AND contra=?";
    if ($stmt = $conn->prepare($query_prof)) {
        $stmt->bind_param("ss", $nickname, $contraseña);
        $stmt->execute();
        $result_prof = $stmt->get_result();
        if ($result_prof->num_rows > 0) {
            $_SESSION['user'] = $result_prof->fetch_assoc();
            header("Location: interfazdocentes.php");
            exit();
        }
        $stmt->close();
    }

    // Consulta para verificar si es alumno
    $query_est = "SELECT * FROM est WHERE nickname=? AND contraseña=?";
    if ($stmt = $conn->prepare($query_est)) {
        $stmt->bind_param("ss", $nickname, $contraseña);
        $stmt->execute();
        $result_est = $stmt->get_result();
        if ($result_est->num_rows > 0) {
            $_SESSION['user'] = $result_est->fetch_assoc();
            header("Location: interfazalumnos.php");
            exit();
        }
        $stmt->close();
    }

    // Si no se encuentra al usuario en ninguna tabla, redirigir con un mensaje de error
    header("Location: index.php?error=Usuario o contraseña incorrectos");
    exit();
}
?>
