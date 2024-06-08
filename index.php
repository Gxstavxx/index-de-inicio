<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INICIO DE SESION</title>
    <link rel="stylesheet" href="estilos1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="background">

    <center>

        <div id="A1" class="card col-sm-3" style="margin-top: 7%;">

            <div class="card-body login-card-body">

                <?php
                if(isset($_GET['error'])){
                    echo "<div class='alert alert-danger alert-dismissible'>";
                    echo "<h5><i class='icon fas fa-ban'></i> Alert!</h5>";
                    echo $_GET['error'];
                    echo "</div>";
                } ?>

                <p class="login-box-msg"> <b>Login</b></p>
                <form action="revisar.php" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="correo" class="form-control" placeholder="Ingrese su correo" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required>
                    </div>
                    <div class="row">
                        <center>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block">INICIAR SESION</button>
                            </div>
                        </center>
                    </div>
                </form>
                <form action="registrar.php" method="post">
                    <div class="social-auth-links text-center mb-3">
                        <br>
                        <button type="submit" class="btn btn-primary btn-block">CREAR CUENTA NUEVA</button>
                    </div><br>
                </form>
                <form action="recuperar.php" method="post">
                    <center>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block">Recuperar Contraseña</button><br>
                        </div>
                    </center>
                </form>
            </div>

        </div>
    </center>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
