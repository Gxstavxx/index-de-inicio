<?php
include "conexion.php";

// Realizar la consulta SQL
$query = "SELECT id, carrera, descripcion FROM Carrera"; // Ajusta según la estructura de tu tabla

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carreras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            padding-top: 50px;
        }
        .actions a {
            margin-bottom: 3px; /* Ajusta el margen según sea necesario */
        }
        .btn-group-sm > .btn {
            width: 100px; /* Ajusta este valor según sea necesario para igualar los tamaños */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center mb-4">REGISTRO DE CARRERAS</h1>
                <a href="registroasignatura.php" class="btn btn-block btn-outline-info btn-sm">Agregar Carrera</a>

                <div class="card">
                    <div class="card-body">
                        <div class="btn-group btn-group-sm mb-3" role="group">
                            <a href="interfazprincipal.php" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Regresar</a>
                            <a href="Grado.php" class="btn btn-primary"><i class="fas fa-edit"></i> Grados</a>
                            <a href="cerrar.php" class="btn btn-danger">Cerrar Sesión</a>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre de la Carrera</th>
                                    <th scope="col">Descripción de la Carrera</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result && $result->num_rows > 0) {
                                    while ($dat = $result->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?php echo $dat->id; ?></td>
                                        <td><?php echo $dat->carrera; ?></td>
                                        <td><?php echo $dat->descripcion; ?></td>
                                        <td class="actions">
                                            <a href="editarasignatura.php?id=<?php echo $dat->id; ?>" class="btn btn-small btn-warning"><i class="fas fa-wrench"></i></a>
                                            <a href="eliminar2.php?id=<?php echo $dat->id; ?>" class="btn btn-small btn-danger"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                    $result->close(); // Liberar el conjunto de resultados
                                } else {
                                    echo "<tr><td colspan='4'>No hay registros encontrados</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
