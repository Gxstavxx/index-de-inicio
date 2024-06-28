<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Asignatura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f0f0f0;
            padding-top: 20px;
        }

        .card {
            margin-top: 6%;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4 text-center">Editar Asignatura</h2>
                        <?php
                        include "conexion.php";
                        $id = $_GET['id'];
                        $sql = $conn->query("SELECT * FROM asig WHERE id='$id'");
                        if ($dat = $sql->fetch_object()) {
                        ?>
                        <form action="edit.php" method="post">
                            <!-- Campo oculto para enviar el ID -->
                            <input type="hidden" name="id" value="<?php echo $dat->id; ?>">
                            <input type="hidden" name="tipo" value="asignatura">
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres</label>
                                <input type="text" name="nombres" class="form-control"
                                    placeholder="Ingrese nombres"
                                    value="<?php echo isset($dat->nombres) ? htmlspecialchars($dat->nombres) : ''; ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control"
                                    placeholder="Ingrese apellidos"
                                    value="<?php echo isset($dat->apellidos) ? htmlspecialchars($dat->apellidos) : ''; ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="grado" class="form-label">Grado</label>
                                <input type="text" name="grado" class="form-control" placeholder="Ingrese grado"
                                    value="<?php echo isset($dat->grado) ? htmlspecialchars($dat->grado) : ''; ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="carrera" class="form-label">Carrera</label>
                                <input type="text" name="carrera" class="form-control" placeholder="Ingrese carrera"
                                    value="<?php echo isset($dat->Carrera) ? htmlspecialchars($dat->Carrera) : ''; ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="materia" class="form-label">Materia</label>
                                <input type="text" name="materia" class="form-control" placeholder="Ingrese materia"
                                    value="<?php echo isset($dat->Materia) ? htmlspecialchars($dat->Materia) : ''; ?>"
                                    required>
                            </div>
                            <center>
                                <div class="row justify-content-center">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-block btn-outline-primary">Guardar
                                            Cambios</button>
                                    </div>
                                </div>
                            </center>
                        </form>
                        <center>
                            <form action="interfaz1.php">
                                <div class="col-6">
                                    <center>
                                        <br><button type="submit" class="btn btn-primary btn-block"><i
                                                class="fas fa-arrow-left"></i> Regresar</button><br>
                                    </center>
                                </div>
                            </form>
                        </center>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tipoBusqueda2 = document.getElementById('tipoBusqueda2');
            const formProfesor = document.getElementById('formProfesor');

            tipoBusqueda2.addEventListener('change', function () {
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
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>
