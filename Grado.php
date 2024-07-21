<?php
include "conexion.php";

// Realizar la consulta SQL para obtener los grados y las carreras
$queryGrado = "SELECT DISTINCT grado FROM Grado";
$queryCarrera = "SELECT DISTINCT c.Carrera FROM Grado g JOIN Carrera c ON g.carreraselec = c.id";
$resultGrado = $conn->query($queryGrado);
$resultCarrera = $conn->query($queryCarrera);

// Realizar la consulta SQL para obtener los grados con el nombre de la carrera
$query = "SELECT g.id, g.grado, c.Carrera AS carrera
          FROM Grado g
          JOIN Carrera c ON g.carreraselec = c.id";
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
        .form-control {
            width: 200px; /* Ajusta este valor según sea necesario */
            margin-right: 10px;
        }
        .btn-group .form-control {
            margin-left: 10px;
            width: 200px; /* Ajusta este valor según sea necesario */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center mb-4">Grados sobre la Carrera</h1>
                <a href="regigrado.php" class="btn btn-block btn-outline-info btn-sm">Agregar Grado</a>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="interfazprincipal.php" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Regresar</a>
                                <a href="cerrar.php" class="btn btn-danger">Cerrar Sesión</a>
                            </div>
                            <!-- Campos de búsqueda -->
                            <div class="d-flex">
                                <select id="searchGrado" class="form-control">
                                    <option value="">Seleccionar Grado</option>
                                    <?php while ($row = $resultGrado->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['grado']; ?>"><?php echo $row['grado']; ?></option>
                                    <?php } ?>
                                </select>
                                <select id="searchCarrera" class="form-control">
                                    <option value="">Seleccionar Carrera</option>
                                    <?php while ($row = $resultCarrera->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['Carrera']; ?>"><?php echo $row['Carrera']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Grado</th>
                                    <th scope="col">Carrera</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <?php
                                if ($result && $result->num_rows > 0) {
                                    while ($dat = $result->fetch_object()) {
                                ?>
                                    <tr data-grado="<?php echo $dat->grado; ?>" data-carrera="<?php echo $dat->carrera; ?>">
                                        <td><?php echo $dat->id; ?></td>
                                        <td><?php echo $dat->grado; ?></td>
                                        <td><?php echo $dat->carrera; ?></td>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchGrado = document.getElementById('searchGrado');
            const searchCarrera = document.getElementById('searchCarrera');
            const tableBody = document.getElementById('table-body');

            function filterTable() {
                const selectedGrado = searchGrado.value.toLowerCase();
                const selectedCarrera = searchCarrera.value.toLowerCase();

                Array.from(tableBody.querySelectorAll('tr')).forEach(row => {
                    const grado = row.dataset.grado.toLowerCase();
                    const carrera = row.dataset.carrera.toLowerCase();

                    const isMatch =
                        (selectedGrado === '' || grado.includes(selectedGrado)) &&
                        (selectedCarrera === '' || carrera.includes(selectedCarrera));

                    row.style.display = isMatch ? '' : 'none';
                });
            }

            searchGrado.addEventListener('change', filterTable);
            searchCarrera.addEventListener('change', filterTable);
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>
