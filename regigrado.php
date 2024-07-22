<?php
include "conexion.php";

// Consulta para obtener todas las carreras para el campo de selección
$query = "SELECT id, Carrera FROM Carrera";
$result = $conn->query($query);
?>

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
        .form-select {
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4 text-center">Registro de Grado</h2>
                        <?php if (isset($errorMsg)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo htmlspecialchars($errorMsg); ?>
                            </div>
                        <?php endif; ?>
                        <form action="intregigrado.php" method="post">
                            <!-- Campo oculto para ID de Carrera -->
                            <input type="hidden" name="carrera_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">

                            <div class="mb-3">
                                <label for="grado" class="form-label">Agregar Grado</label>
                                <input type="text" name="grado" class="form-control" placeholder="Ingrese el grado" required>
                            </div>
                            <div class="mb-3">
                                <label for="selectcarrera" class="form-label">Para qué Carrera</label>
                                <!-- Campo de selección con lista de carreras -->
                                <select id="selectcarrera" name="selectcarrera" class="form-select" required>
                                    <option value="">Seleccione una carrera</option>
                                    <?php
                                    if ($result && $result->num_rows > 0) {
                                        while ($dat = $result->fetch_object()) {
                                            echo "<option value='{$dat->id}'>{$dat->Carrera}</option>";
                                        }
                                    }
                                    ?>
                                </select>
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
                            <form action="Grado.php">
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

<?php $conn->close(); ?>
