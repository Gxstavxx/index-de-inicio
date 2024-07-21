<?php
include "conexion.php";

// Consultar la tabla CursoAsignado para obtener las opciones únicas
$query = "SELECT DISTINCT Materia, paraqcar, paraqgra FROM CursoAsignado";
$filterResult = $conn->query($query);

// Consultar la tabla CursoAsignado para obtener todos los registros
$query = "SELECT * FROM CursoAsignado";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Cursos Asignados</title>
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
        .form-group {
            display: flex;
            gap: 10px; /* Espacio entre campos de búsqueda */
            align-items: center;
            margin-bottom: 20px;
        }
        .form-control {
            width: 200px; /* Ajusta el ancho de los campos de búsqueda según sea necesario */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center mb-4">Listado de Cursos Asignados</h1>
                <a href="regicursos.php" class="btn btn-block btn-outline-info btn-sm">Agregar Curso</a>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="interfazprincipal.php" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Regresar</a>
                                <a href="cerrar.php" class="btn btn-danger">Cerrar Sesión</a>
                            </div>
                            <div class="form-group">
                                <select id="filter-carrera" class="form-control">
                                    <option value="">Seleccionar Carrera</option>
                                    <?php
                                    $paraqcarSet = [];
                                    $filterResult->data_seek(0); // Resetear el puntero de resultados
                                    while ($row = $filterResult->fetch_object()) {
                                        if (!in_array($row->paraqcar, $paraqcarSet)) {
                                            $paraqcarSet[] = $row->paraqcar;
                                            echo "<option value=\"" . htmlspecialchars($row->paraqcar) . "\">" . htmlspecialchars($row->paraqcar) . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <select id="filter-grado" class="form-control">
                                    <option value="">Seleccionar Grado</option>
                                    <?php
                                    $paraqgraSet = [];
                                    $filterResult->data_seek(0); // Resetear el puntero de resultados
                                    while ($row = $filterResult->fetch_object()) {
                                        if (!in_array($row->paraqgra, $paraqgraSet)) {
                                            $paraqgraSet[] = $row->paraqgra;
                                            echo "<option value=\"" . htmlspecialchars($row->paraqgra) . "\">" . htmlspecialchars($row->paraqgra) . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <select id="filter-materia" class="form-control">
                                    <option value="">Seleccionar Materia</option>
                                    <?php
                                    $materiaSet = [];
                                    $filterResult->data_seek(0); // Resetear el puntero de resultados
                                    while ($row = $filterResult->fetch_object()) {
                                        if (!in_array($row->Materia, $materiaSet)) {
                                            $materiaSet[] = $row->Materia;
                                            echo "<option value=\"" . htmlspecialchars($row->Materia) . "\">" . htmlspecialchars($row->Materia) . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Materia</th>
                                    <th scope="col">Para qué Carrera</th>
                                    <th scope="col">Para qué Grado</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <?php
                                if ($result && $result->num_rows > 0) {
                                    while ($dat = $result->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?php echo $dat->id; ?></td>
                                        <td><?php echo $dat->Materia; ?></td>
                                        <td><?php echo $dat->paraqcar; ?></td>
                                        <td><?php echo $dat->paraqgra; ?></td>
                                        <td class="actions">
                                            <a href="editar_curso_asignado.php?id=<?php echo $dat->id; ?>" class="btn btn-warning btn-sm"><i class="fas fa-wrench"></i></a>
                                            <a href="eliminar_curso_asignado.php?id=<?php echo $dat->id; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                    $result->close(); // Liberar el conjunto de resultados
                                } else {
                                    echo "<tr><td colspan='5'>No hay registros encontrados</td></tr>";
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
        document.getElementById('filter-materia').addEventListener('change', filterTable);
        document.getElementById('filter-carrera').addEventListener('change', filterTable);
        document.getElementById('filter-grado').addEventListener('change', filterTable);

        function filterTable() {
            var materiaFilter = document.getElementById('filter-materia').value.toLowerCase();
            var carreraFilter = document.getElementById('filter-carrera').value.toLowerCase();
            var gradoFilter = document.getElementById('filter-grado').value.toLowerCase();
            var rows = document.querySelectorAll('#table-body tr');

            rows.forEach(function(row) {
                var materia = row.cells[1].textContent.toLowerCase();
                var carrera = row.cells[2].textContent.toLowerCase();
                var grado = row.cells[3].textContent.toLowerCase();

                if (
                    (materiaFilter === '' || materia.includes(materiaFilter)) &&
                    (carreraFilter === '' || carrera.includes(carreraFilter)) &&
                    (gradoFilter === '' || grado.includes(gradoFilter))
                ) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
