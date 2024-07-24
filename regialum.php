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

// Consultar grados y carreras para los select
$grados = $conn->query("SELECT id, grado FROM grado");
$carreras = $conn->query("SELECT id, Carrera FROM carrera");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Alumnos</title>
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
            gap: 5px; /* Espacio entre botones */
        }
        .actions .btn, .actions select {
            font-size: 0.8rem; /* Tamaño de fuente más pequeño */
            padding: 2px 5px; /* Ajusta el tamaño del botón */
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
                        <div class="actions mb-3">
                            <a href="interfazprincipal.php" class="btn btn-small btn-danger"><i class="fas fa-arrow-left"></i> Regresar</a>
                            <a href="cerrar.php" class="btn btn-small btn-danger">Cerrar Sesion</a>
                            <select id="filterGrado" class="form-control form-control-sm ml-2">
                                <option value="">Todos los Grados</option>
                                <?php while ($row = $grados->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['grado']; ?>"><?php echo $row['grado']; ?></option>
                                <?php } ?>
                            </select>
                            <select id="filterCarrera" class="form-control form-control-sm ml-2">
                                <option value="">Todas las Carreras</option>
                                <?php while ($row = $carreras->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['Carrera']; ?>"><?php echo $row['Carrera']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
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
                            <tbody id="studentTable">
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

    <script>
        document.getElementById('filterGrado').addEventListener('change', filterTable);
        document.getElementById('filterCarrera').addEventListener('change', filterTable);

        function filterTable() {
            const filterGrado = document.getElementById('filterGrado').value.toLowerCase();
            const filterCarrera = document.getElementById('filterCarrera').value.toLowerCase();
            const table = document.getElementById('studentTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                const grado = cells[3].innerText.toLowerCase();
                const carrera = cells[4].innerText.toLowerCase();

                if ((filterGrado === "" || grado.includes(filterGrado)) &&
                    (filterCarrera === "" || carrera.includes(filterCarrera))) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
