<?php
include "conexion.php";

// Consultar los grados
$query = "SELECT id, Materia, descripcion FROM Curso"; // Ajusta según la estructura de tu tabla
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grado</title>
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
        .actions {
            display: flex;
            gap: 10px; /* Espacio entre botones */
        }
        .actions .btn {
            width: 80px; /* Ajusta el ancho a un valor fijo */
            text-align: center; /* Alinea el texto y el ícono en el centro */
            padding: 5px 8px; /* Ajusta el tamaño del botón */
        }
        .btn-professor {
            color: white; /* Color del ícono */
            background-color: green; /* Color de fondo verde */
            font-size: 1.1rem; /* Tamaño del ícono */
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
                <h1 class="text-center mb-4">Cursos sobre la carrera</h1>
                <a href="regicursos.php" class="btn btn-block btn-outline-info btn-sm">Agregar Curso</a>

                <div class="card">
                    <div class="card-body">
                        <div class="btn-group btn-group-sm mb-3" role="group">
                            <a href="interfazprincipal.php" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Regresar</a>
                            <a href="cerrar.php" class="btn btn-danger">Cerrar Sesión</a>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Materia</th>
                                    <th scope="col">Descripción de Curso</th>
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
                                        <td><?php echo $dat->Materia; ?></td>
                                        <td><?php echo $dat->descripcion; ?></td>
                                        <td class="actions">
                                            <a href="asigprof.php?id=<?php echo $dat->id; ?>" class="btn btn-small btn-professor"><i class="fas fa-chalkboard-teacher"></i></a>
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
