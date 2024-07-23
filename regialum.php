<?php
include 'conexion.php';

// Consultar los datos de los estudiantes
$query = "
  SELECT 
        est.id,
        est.nombres,
        est.apellidos,
        g.grado,
        c.Carrera,
        est.nickname,
        est.correo,
        est.contra AS contraseña
    FROM est
    LEFT JOIN grado g ON est.grado = g.id
    LEFT JOIN carrera c ON est.carrera = c.id
";
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center mb-4">Registro de Alumnos</h1>
                <a href="registrar.php" class="btn btn-block btn-outline-info btn-sm">Deseas Registrar un Alumno</a>

                <div class="card">
                    <div class="card-body">
                        <a href="asignatura.php" class="btn btn-small btn-danger mb-3"><i class="fas fa-arrow-left"></i> Regresar</a>
                        <a href="cerrar.php" class="btn btn-small btn-danger mb-3">Cerrar Sesion</a>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombres</th>
                                    <th scope="col">Apellidos</th>
                                    <th scope="col">Grado</th>
                                    <th scope="col">Carrera</th>
                                    <th scope="col">Nick</th>
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
                                        <td><?php echo $dat->grado; ?></td>
                                        <td><?php echo $dat->Carrera; ?></td>
                                        <td><?php echo $dat->nickname; ?></td>
                                        <td><?php echo $dat->correo; ?></td>
                                        <td><?php echo $dat->contraseña; ?></td>
                                        <td class="actions">
                                            <a href="editarasignatura.php?id=<?php echo $dat->id; ?>" class="btn btn-small btn-warning"><i class="fas fa-wrench"></i></a>
                                            <a href="eliminar2.php?id=<?php echo $dat->id; ?>" class="btn btn-small btn-danger"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='9' class='text-center'>No se encontraron datos.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
