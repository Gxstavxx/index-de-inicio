<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>REGISTRO DE GRADO</title>
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
                        <h2 class="mb-4 text-center">Registro de Cursos</h2>
                        <form action="intcursos.php" method="post">
                            <!-- Campo oculto para ID de Carrera -->
                            <input type="hidden" name="carrera_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">

                            <div class="mb-3">
                                <label for="curso" class="form-label">Agregar Curso</label>
                                <input type="text" name="curso" class="form-control" placeholder="Ingrese el curso" required>
                            </div>
                            <div class="mb-3">
                                <label for="des" class="form-label">Descripcion</label>
                                <input type="text" name="desc" class="form-control" placeholder="Ingrese la descripcion del grado" required>
                            </div>

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
