<?php
include "conexion.php";

// Realizar la consulta SQL
$query = "SELECT id, nombres, apellidos, nickname, correo, contraseña FROM prof"; // Ajusta según la estructura de tu tabla

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz Administrador</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center mb-4">Registros de Docentes</h1>
                <a href="registrarpro.php" class="btn btn-block btn-outline-info btn-sm">¿Deseas Registrar un Nuevo Docente?</a>
                <a href="cerrar.php" class="btn btn-block btn-outline-danger btn-sm">Cerrar Sesion</a>

                <div class="card">
                    <div class="card-body">
                        <?php
                        if ($result && $result->num_rows > 0) {
                            $dat = $result->fetch_object(); // Obtener un objeto para el ID
                        ?>
                            <a href="asignatura.php?id=<?php echo $dat->id; ?>" class="btn btn-small btn-success mb-3"><i class="fas fa-edit"></i> Asignatura</a>
                            
                        <?php
                            $result->data_seek(0); // Reiniciar el puntero del conjunto de resultados
                        }
                        ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombres</th>
                                    <th scope="col">Apellidos</th>
                                    <th scope="col">NickName</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Contraseña</th>
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
                                        <td><?php echo $dat->nombres; ?></td>
                                        <td><?php echo $dat->apellidos; ?></td>
                                        <td><?php echo $dat->nickname; ?></td>
                                        <td><?php echo $dat->correo; ?></td>
                                        <td><?php echo $dat->contraseña; ?></td>
                                        <td>
                                            <a href="editar.php?id=<?php echo $dat->id; ?>" class="btn btn-small btn-warning"><i class="fas fa-wrench"></i></a>
                                            <a href="eliminar.php?id=<?php echo $dat->id; ?>" class="btn btn-small btn-danger"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                    $result->close(); // Liberar el conjunto de resultados
                                } else {
                                    echo "<tr><td colspan='7'>No hay registros encontrados</td></tr>";
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
