<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RECUPERAR CONTRASEÑA</title>
    <link rel="stylesheet" href="estilos1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="background2">

    <center>
        <div id="B2" class="card col-sm-3" style="margin-top: 7%;">
            <div class="card-body login-card-body">
                <p class="login-box-msg"><b>RECUPERAR CONTRASEÑA</b></p>
                
                <div class="custom-controls-stacked row text-center pb-3">
                    <div class="custom-control custom-radio col-md-4 text-right">
                        <input id="tipoBusqueda1" name="tipoBusqueda" value="1" type="radio" class="custom-control-input tipoBusqueda" checked="checked">
                        <label for="tipoBusqueda1" class="custom-control-label">Alumno</label>
                    </div>
                    <div class="custom-control custom-radio col-md-4 text-left">
                        <input id="tipoBusqueda3" name="tipoBusqueda" value="3" type="radio" class="custom-control-input tipoBusqueda">
                        <label for="tipoBusqueda3" class="custom-control-label">Docente</label>
                    </div>
                </div>

                <!-- Formulario Alumno -->
                <form id="formAlumno" action="rc.php" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="correo" class="form-control" placeholder="Correo" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="nickname" id="nicknameAlumno" class="form-control" placeholder="Usuario" required onblur="addAlumToNickname(this)">
                    </div>
                    <input type="hidden" name="tipo" value="alumno">
                    <div class="row">
                        <center>
                            <div class="col-6">
                                <button type="
submit" class="btn btn-block btn-outline-primary btn-sm">Verificar</button><br>
                            </div>
                        </center>
                    </div>
                </form>

                <!-- Formulario Docente -->
                <form id="formDocente" action="rc.php" method="post" style="display: none;">
                    <div class="input-group mb-3">
                        <input type="email" name="correo" class="form-control" placeholder="Correo" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="nickname" id="nicknameDocente" class="form-control" placeholder="Usuario" required onblur="addAlumToUsuario(this)">
                    </div>
                    <input type="hidden" name="tipo" value="docente">
                    <div class="row">
                        <center>
                            <div class="col-6">
                                <button type="submit" class="btn btn-block btn-outline-primary btn-sm">Verificar</button><br>
                            </div>
                        </center>
                    </div>
                </form>

                <form action="index.php">
                    <div class="col-6">
                        <br><button type="submit" class="btn btn-primary btn-block"><i class="fas fa-arrow-left"></i> Regresar</button><br>
                    </div>
                </form>
            </div>
        </div>
    </center>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tipoBusqueda1 = document.getElementById('tipoBusqueda1');
        const tipoBusqueda3 = document.getElementById('tipoBusqueda3');
        const formAlumno = document.getElementById('formAlumno');
        const formDocente = document.getElementById('formDocente');

        tipoBusqueda1.addEventListener('change', function() {
            if (tipoBusqueda1.checked) {
                formAlumno.style.display = 'block';
                formDocente.style.display = 'none';
            }
        });

        tipoBusqueda3.addEventListener('change', function() {
            if (tipoBusqueda3.checked) {
                formAlumno.style.display = 'none';
                formDocente.style.display = 'block';
            }
        });
    });

    function addAlumToNickname(input) {
        const value = input.value.trim();
        const cursorPosition = input.selectionStart;
        const lastIndexOfAlum = value.lastIndexOf('-alum');

        if (lastIndexOfAlum === -1 || cursorPosition <= lastIndexOfAlum) {
            input.value = value + '-alum';
        } else if (cursorPosition > lastIndexOfAlum + 5) {
            input.setSelectionRange(lastIndexOfAlum + 5, lastIndexOfAlum + 5);
        }
    }

    function addAlumToUsuario(input) {
        const value = input.value.trim();
        const cursorPosition = input.selectionStart;
        const lastIndexOfAlum = value.lastIndexOf('-alum');
        const lastIndexOfProf = value.lastIndexOf('-prof');

        if (lastIndexOfProf === -1 && (lastIndexOfAlum === -1 || cursorPosition <= lastIndexOfAlum)) {
            input.value = value + '-prof';
        } else if (lastIndexOfProf !== -1 || cursorPosition > lastIndexOfProf + 5) {
            input.setSelectionRange(lastIndexOfProf + 5, lastIndexOfProf + 5);
        }
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
