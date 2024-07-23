<?php
include 'conexion.php';

// Consultar los datos con nombres
$query = "
    SELECT 
        ca.id, 
        ca.Docente, 
        ca.Profesion AS Profesion,
        c.Carrera AS paraqcar,
        g.grado AS paraqgra,
        cu.Materia AS cursig
    FROM cursoasig ca
    LEFT JOIN Carrera c ON ca.paraqcar = c.id
    LEFT JOIN Grado g ON ca.paraqgra = g.id
    LEFT JOIN CursoAsignado cu ON ca.cursig = cu.id
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
                <h1 class="text-center mb-4">Asignar Profesor al Curso</h1>
                <a href="regiasignaprof.php" class="btn btn-block btn-outline-info btn-sm">Asignar Profesor</a>

                <div class="card">
                    <div class="card-body">
                        <a href="asignatura.php" class="btn btn-small btn-danger mb-3"><i class="fas fa-arrow-left"></i> Regresar</a>
                        <a href="cerrar.php" class="btn btn-small btn-danger mb-3">Cerrar Sesion</a>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Profesor</th>
                                    <th scope="col">Profesion</th>
                                    <th scope="col">Para qué Carrera</th>
                                    <th scope="col">Para qué Grado</th>
                                    <th scope="col">Materia Asignada</th>
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
                                        <td><?php echo $dat->Docente; ?></td>
                                        <td><?php echo $dat->Profesion; ?></td>
                                        <td><?php echo $dat->paraqcar; ?></td>
                                        <td><?php echo $dat->paraqgra; ?></td>
                                        <td><?php echo $dat->cursig; ?></td>
                                        <td class="actions">
                                            <a href="editarasignatura.php?id=<?php echo $dat->id; ?>" class="btn btn-small btn-warning"><i class="fas fa-wrench"></i></a>
                                            <a href="eliminar2.php?id=<?php echo $dat->id; ?>" class="btn btn-small btn-danger"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No se encontraron datos.</td></tr>";
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
