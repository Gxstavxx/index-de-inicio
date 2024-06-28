<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AGREGAR ASIGNATURA</title>
    <link rel="stylesheet" href="estilos1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="background2">

    <center>
        <div id="B2" class="card col-sm-6" style="margin-top: 6%;">

            <div class="card-body login-card-body">
                <p class="login-box-msg"><b>AGREGAR ASIGNATURA</b></p>
                <form id="formProfesor" action="registropro.php" method="post">
                <!-- Formulario Buscar Profesor -->
                <form id="buscarProfesorForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="buscar_profesor" class="form-control" placeholder="Buscar por ID, Nombre o Apellido de Profesor" required>
                        <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                    </div>
                </form>

                <!-- Resultados de la búsqueda -->
                <div id="resultadosBusqueda" class="mt-4">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
                        include 'conexion.php';

                        $buscar_profesor = $_POST['buscar_profesor'];

                        // Determinar si la búsqueda es por ID (numérica) o por nombre/apellido (texto)
                        if (is_numeric($buscar_profesor)) {
                            $sql = "SELECT id, nombres, apellidos FROM prof WHERE id = ?";
                        } else {
                            $sql = "SELECT id, nombres, apellidos FROM prof WHERE nombres LIKE ? OR apellidos LIKE ?";
                            $buscar_profesor = "%" . $buscar_profesor . "%";
                        }

                        if ($stmt = $conn->prepare($sql)) {
                            if (is_numeric($buscar_profesor)) {
                                $stmt->bind_param("i", $buscar_profesor);
                            } else {
                                $stmt->bind_param("ss", $buscar_profesor, $buscar_profesor);
                            }
                            $stmt->execute();
                            $stmt->store_result();

                            if ($stmt->num_rows > 0) {
                                $stmt->bind_result($profesor_id, $nombres, $apellidos);
                                while ($stmt->fetch()) {
                                    echo "<p>Profesor encontrado: ID: $profesor_id, Nombre: $nombres, Apellido: $apellidos</p>";
                                }
                            } else {
                                echo "<p>Profesor no encontrado</p>";
                            }

                            $stmt->close();
                        }

                        $conn->close();
                    }
                    ?>
                </div>

                <form action="interfaz1.php">
                    <button type="submit" class="btn btn-primary btn-block mt-3"><i class="fas fa-arrow-left"></i> Regresar</button>
                </form>
            </div>
        </div>
    </center>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
