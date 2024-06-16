<?php
include "conexion.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz Administrador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                <a href="registrarpro.php" class="btn btn-primary mb-3">Deseas Registrar un Nuevo Usuario?</a>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombres</th>
                                    <th scope="col">Apellidos</th>
                                    <th scope="col">Carrera</th>
                                    <th scope="col">Materia</th>
                                    <th scope="col">NickName</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Contraseña</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($dat = $sql->fetch_object()): ?>
                                    <tr>
                                        <td><?php echo $dat->id; ?></td>
                                        <td><?php echo $dat->nombres; ?></td>
                                        <td><?php echo $dat->apellidos; ?></td>
                                        <td><?php echo $dat->edad; ?></td>
                                        <td><?php echo $dat->direccion; ?></td>
                                        <td><?php echo $dat->encargado; ?></td>
                                        <td><?php echo $dat->tel_encargado; ?></td>
                                        <td>
                                            <a href="editar.php?id=<?php echo $dat->id; ?>" class="btn btn-warning btn-sm"><i class="fas fa-wrench"></i></a>
                                            <a href="eliminar.php?id=<?php echo $dat->id; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
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
