<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>REGISTRO DE CURSO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                        <h2 class="mb-4 text-center">Registro de Curso</h2>
                        <form action="intcursos.php" method="post">
                            <div class="mb-3">
                                <label for="curso" class="form-label">Agregar Curso</label>
                                <input type="text" name="curso" class="form-control" placeholder="Ingrese el curso" required>
                            </div>

                            <div class="mb-3">
                                <label for="carrera" class="form-label">Para qué Carrera</label>
                                <select name="carrera" class="form-select" required>
                                    <option value="">Seleccione una carrera</option>
                                    <?php
                                    include 'conexion.php';
                                    $query_carrera = "SELECT id, Carrera FROM carrera";
                                    $result_carrera = $conn->query($query_carrera);
                                    if ($result_carrera && $result_carrera->num_rows > 0) {
                                        while ($dat_carrera = $result_carrera->fetch_object()) {
                                            echo "<option value='{$dat_carrera->id}'>{$dat_carrera->Carrera}</option>";
                                        }
                                    }
                                    $result_carrera->close();
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="grado" class="form-label">Para qué Grado</label>
                                <select name="grado" class="form-select" required>
                                    <option value="">Seleccione un grado</option>
                                    <?php
                                    include 'conexion.php';
                                    $query_grado = "SELECT DISTINCT grado, id FROM grado ORDER BY grado";
                                    $result_grado = $conn->query($query_grado);

                                    // Filtrar duplicados en PHP
                                    $seen = array();
                                    if ($result_grado && $result_grado->num_rows > 0) {
                                        while ($dat_grado = $result_grado->fetch_object()) {
                                            if (!in_array($dat_grado->grado, $seen)) {
                                                $seen[] = $dat_grado->grado;
                                                echo "<option value='{$dat_grado->id}'>{$dat_grado->grado}</option>";
                                            }
                                        }
                                    }
                                    $result_grado->close();
                                    $conn->close();
                                    ?>
                                </select>
                            </div>

                            <?php if (isset($errorMsg)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $errorMsg; ?>
                                </div>
                            <?php endif; ?>

                            <center>
                                <div class="row justify-content-center">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-block btn-outline-primary">Guardar Cambios</button>
                                    </div>
                                </div>
                            </center>
                        </form>
                        <center>
                            <form action="Cursos.php">
                                <div class="col-6">
                                    <center>
                                        <br><button type="submit" class="btn btn-primary btn-block"><i class="fas fa-arrow-left"></i> Regresar</button><br>
                                    </center>
                                </div>
                            </form>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
