<?php
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscar'])) {
    $buscar = $_POST['buscar'];
    $query = "SELECT id, nombres, apellidos FROM prof WHERE id = ? OR nombres LIKE ?";
    $stmt = $conn->prepare($query);
    $likeBuscar = "%$buscar%";
    $stmt->bind_param("is", $buscar, $likeBuscar);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $resultadoBusqueda = '
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Resultado de la Búsqueda</h5>
                    <p class="card-text"><strong>Nombres:</strong> ' . $data['nombres'] . '</p>
                    <p class="card-text"><strong>Apellidos:</strong> ' . $data['apellidos'] . '</p>
                </div>
            </div>';
    } else {
        $resultadoBusqueda = '<div class="alert alert-danger" role="alert">Docente no encontrado</div>';
    }
    $stmt->close();
} else {
    $resultadoBusqueda = '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    $nombres = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $nickname = $_POST['nickname'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $contra = md5($contraseña);

    $sql = "INSERT INTO prof (nombres, apellidos, nickname, correo, contraseña, contra) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $nombres, $apellidos, $nickname, $correo, $contraseña, $contra);

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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>REGISTRAR USUARIO</title>
    <link rel="stylesheet" href="estilos1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="background2">

    <center>
        <div id="B2" class="card col-sm-3" style="margin-top: 6%;">
            <div class="card-body login-card-body">
                <p class="login-box-msg"><b>ASIGNATURA</b></p>
                
                <div class="custom-controls-stacked row text-center pb-3">
                    <div class="custom-control custom-radio col-md-4 text-right">
                        <input id="tipoBusqueda2" name="tipoBusqueda" value="2" type="radio" class="custom-control-input tipoBusqueda" checked="checked">
                        <label for="tipoBusqueda2" class="custom-control-label">Profesor</label>
                    </div>
                </div>

                <!-- Formulario Profesor -->
                <form id="formBuscarProfesor" action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Ingrese el Nombre o Id" required>
                        <button type="submit" class="btn btn-outline-secondary">Buscar</button>
                    </div>
                </form>

                <div id="resultadoBusqueda" class="mb-3"><?= $resultadoBusqueda ?></div>

                <form id="formRegistrarProfesor" action="" method="post">
                    <input type="hidden" name="tipo" value="profesor">
                    <div class="input-group mb-3">
                        <input type="text" name="nombre" class="form-control" placeholder="Ingrese el Grado" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="apellido" class="form-control" placeholder="Ingrese la Carrera" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="nickname" class="form-control" placeholder="Ingrese la Materia" required>
                    </div>
                   
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <button type="submit" class="btn btn-block btn-outline-primary btn-sm">Agregar</button><br>
                        </div>
                    </div>
                </form>

                <form action="interfaz1.php">
                    <div class="col-6">
                        <br><button type="submit" class="btn btn-primary btn-block"><i class="fas fa-arrow-left"></i> Regresar</button>
                        <br>
                    </div>
                </form>
            </div>
        </div>
    </center>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tipoBusqueda2 = document.getElementById('tipoBusqueda2');
        const formProfesor = document.getElementById('formRegistrarProfesor');

        tipoBusqueda2.addEventListener('change', function() {
            if (tipoBusqueda2.checked) {
                formProfesor.style.display = 'block';
            }
        });
    });

    function addProfToNickname(input) {
        const value = input.value.trim();
        const cursorPosition = input.selectionStart;
        const lastIndexOfProf = value.lastIndexOf('-prof');

        if (lastIndexOfProf === -1 || cursorPosition <= lastIndexOfProf) {
            input.value = value + '-prof';
        } else if (cursorPosition > lastIndexOfProf + 5) {
            input.setSelectionRange(lastIndexOfProf + 5, lastIndexOfProf + 5);
        }
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
