<?php
include 'conexion.php';

$errorMsg = ''; // Variable para almacenar el mensaje de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $nombres = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $grado = $_POST['grado'];
    $carrera = $_POST['carrera'];
    $nickname = $_POST['nickname'] . '-alum'; // Agregar el sufijo '-alum'
    $correo = $_POST['correo'];
    $contra = $_POST['contraseña'];
    $contraseña = md5($_POST['contraseña']);

    if ($tipo == "alumno") {
        // Verificar si el nickname ya existe
        $checkNickname = "SELECT id FROM est WHERE nickname = ?";
        if ($stmt = $conn->prepare($checkNickname)) {
            $stmt->bind_param("s", $nickname);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows > 0) {
                // Nickname ya existe
                $errorMsg = "El nickname '$nickname' ya está en uso. Elija otro.";
            } else {
                // Insertar en la tabla est (estudiantes)
                $sql = "INSERT INTO est (nombres, apellidos, grado, carrera, nickname, correo, contra, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("ssssssss", $nombres, $apellidos, $grado, $carrera, $nickname, $correo, $contra, $contraseña);
                    if ($stmt->execute()) {
                        header('Location: regialum.php');
                        exit();
                    } else {
                        $errorMsg = "Error al registrar alumno: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $errorMsg = "Error al preparar la consulta para alumno: " . $conn->error;
                }
            }
            $stmt->close();
        }
    }

    $conn->close();
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
                <p class="login-box-msg"><b>CREAR CUENTA</b></p>
                <div class="custom-controls-stacked row text-center pb-3">
                    <div class="custom-control custom-radio col-md-4 text-right">
                        <input id="tipoBusqueda1" name="tipoBusqueda" value="1" type="radio" class="custom-control-input tipoBusqueda" checked="checked">
                        <label for="tipoBusqueda1" class="custom-control-label">Alumno</label>
                    </div>
                </div>
                <!-- Formulario Alumno -->
                <form id="formAlumno" action="registro.php" method="post">
                    <input type="hidden" name="tipo" value="alumno">
                    <div class="input-group mb-3">
                        <input type="text" name="nombre" class="form-control" placeholder="Ingrese sus Nombres" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="apellido" class="form-control" placeholder="Ingrese sus Apellidos" required>
                    </div>
                    <div class="input-group mb-3">
                        <select name="grado" class="form-control" required>
                            <option value="" disabled selected>Seleccione su Grado</option>
                            <?php
                                include 'conexion.php';
                                $result = $conn->query("SELECT id, grado FROM grado");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['grado'] . "</option>";
                                }
                                $result->free();
                                $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <select name="carrera" class="form-control" required>
                            <option value="" disabled selected>Seleccione su Carrera</option>
                            <?php
                                include 'conexion.php';
                                $result = $conn->query("SELECT id, Carrera FROM carrera");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['Carrera'] . "</option>";
                                }
                                $result->free();
                                $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="nickname" id="nickname" class="form-control" placeholder="Usuario" required onblur="addAlumToNickname(this)" value="<?php echo isset($_POST['nickname']) ? htmlspecialchars($_POST['nickname']) : ''; ?>">
                        <?php if ($errorMsg): ?>
                            <div class="invalid-feedback d-block">
                                <?php echo htmlspecialchars($errorMsg); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="correo" class="form-control" placeholder="Correo" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <button type="submit" class="btn btn-block btn-outline-primary btn-sm">CREAR</button><br>
                        </div>
                    </div>
                </form>
                <form action="regialum.php">
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
            const tipoBusqueda1 = document.getElementById('tipoBusqueda1');
            const formAlumno = document.getElementById('formAlumno');

            tipoBusqueda1.addEventListener('change', function() {
                if (tipoBusqueda1.checked) {
                    formAlumno.style.display = 'block';
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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>
</html>
