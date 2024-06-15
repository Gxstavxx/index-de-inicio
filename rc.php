<?php
include 'conexion.php';

$correo = $_POST['correo'];
$nickname = $_POST['nickname'];
$tipo = $_POST['tipo'];

if ($tipo == 'alumno') {
    $sql = "SELECT * FROM est WHERE correo='$correo' AND nickname='$nickname'";
} else if ($tipo == 'docente') {
    $sql = "SELECT * FROM prof WHERE correo='$correo' AND nickname='$nickname'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "
    <html lang='en'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>CAMBIAR CONTRASEÑA</title>
        <link rel='stylesheet' href='estilos1.css'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'
            integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
    </head>
    <body class='background2'>
        <center>
            <div id='B2' class='card col-sm-3' style='margin-top: 7%;'>
                <div class='card-body login-card-body'>
                    <p class='login-box-msg'><b>CAMBIAR CONTRASEÑA</b></p>
                    <form action='recu.php' method='post'>
                        <div class='input-group mb-3'>
                            <input type='password' name='nueva_contrasena' class='form-control' placeholder='Nueva Contraseña' required>
                        </div>
                        <input type='hidden' name='correo' value='$correo'>
                        <input type='hidden' name='nickname' value='$nickname'>
                        <input type='hidden' name='tipo' value='$tipo'>
                        <div class='row'>
                            <center>
                                <div class='col-6'>
                                    <button type='submit' class='btn btn-block btn-outline-primary btn-sm'>Cambiar</button><br>
                                </div>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </center>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'
            integrity='sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'>
        </script>
    </body>
    </html>
    ";
} else {
    echo "Correo o usuario incorrecto.";
}

$conn->close();
?>
