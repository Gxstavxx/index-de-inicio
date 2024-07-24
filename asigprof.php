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

// Obtener opciones para los filtros
$profesoresQuery = "SELECT DISTINCT Docente FROM cursoasig";
$profesoresResult = $conn->query($profesoresQuery);

$profesionesQuery = "SELECT DISTINCT Profesion FROM cursoasig";
$profesionesResult = $conn->query($profesionesQuery);

$carrerasQuery = "SELECT DISTINCT c.Carrera FROM cursoasig ca LEFT JOIN Carrera c ON ca.paraqcar = c.id";
$carrerasResult = $conn->query($carrerasQuery);

$gradosQuery = "SELECT DISTINCT g.grado FROM cursoasig ca LEFT JOIN Grado g ON ca.paraqgra = g.id";
$gradosResult = $conn->query($gradosQuery);

$materiasQuery = "SELECT DISTINCT cu.Materia FROM cursoasig ca LEFT JOIN CursoAsignado cu ON ca.cursig = cu.id";
$materiasResult = $conn->query($materiasQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Profesor al Curso</title>
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
            gap: px; /* Espacio entre botones */
        }
        .actions .btn, .actions .form-control {
            width: auto; /* Ajusta el ancho a un valor más pequeño */
            text-align: center; /* Alinea el texto y el ícono en el centro */
            padding: 3px 5px; /* Ajusta el tamaño del botón */
        }
        .btn-filter {
            width: 150px; /* Ajusta el ancho de los campos de selección */
            padding: 3px 5px; /* Ajusta el tamaño del botón */
        }
        .btn-action {
            margin-right: 0px; /* Espacio entre los botones de acción */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center mb-4">Asignar Profesor al Curso</h1>
                <a href="regiasignaprof.php" class="btn btn-block btn-outline-info btn-sm mb-3">Asignar Profesor</a>

                <div class="card">
                    <div class="card-body">
                        <div class="actions">
                            <a href="interfazprincipal.php" class="btn btn-small btn-danger btn-action"><i class="fas fa-arrow-left"></i> Regresar</a>
                            <a href="cerrar.php" class="btn btn-small btn-danger btn-action">Cerrar Sesión</a>
                            <select id="filtroProfesor" class="form-control btn-filter">
                                <option value="">Selecciona Profesor</option>
                                <?php while($row = $profesoresResult->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['Docente']; ?>"><?php echo $row['Docente']; ?></option>
                                <?php } ?>
                            </select>
                            <select id="filtroProfesion" class="form-control btn-filter">
                                <option value="">Selecciona Profesión</option>
                                <?php while($row = $profesionesResult->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['Profesion']; ?>"><?php echo $row['Profesion']; ?></option>
                                <?php } ?>
                            </select>
                            <select id="filtroCarrera" class="form-control btn-filter">
                                <option value="">Selecciona Carrera</option>
                                <?php while($row = $carrerasResult->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['Carrera']; ?>"><?php echo $row['Carrera']; ?></option>
                                <?php } ?>
                            </select>
                            <select id="filtroGrado" class="form-control btn-filter">
                                <option value="">Selecciona Grado</option>
                                <?php while($row = $gradosResult->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['grado']; ?>"><?php echo $row['grado']; ?></option>
                                <?php } ?>
                            </select>
                            <select id="filtroMateria" class="form-control btn-filter">
                                <option value="">Selecciona Materia</option>
                                <?php while($row = $materiasResult->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['Materia']; ?>"><?php echo $row['Materia']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Profesor</th>
                                    <th scope="col">Profesión</th>
                                    <th scope="col">Para qué Carrera</th>
                                    <th scope="col">Para qué Grado</th>
                                    <th scope="col">Materia Asignada</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaResultados">
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

    <script>
        // Scripts para manejar los filtros
        function filtrarTabla() {
            var filtroProfesor = document.getElementById('filtroProfesor').value.toLowerCase();
            var filtroProfesion = document.getElementById('filtroProfesion').value.toLowerCase();
            var filtroCarrera = document.getElementById('filtroCarrera').value.toLowerCase();
            var filtroGrado = document.getElementById('filtroGrado').value.toLowerCase();
            var filtroMateria = document.getElementById('filtroMateria').value.toLowerCase();

            var table = document.getElementById('tablaResultados');
            var tr = table.getElementsByTagName('tr');

            for (var i = 0; i < tr.length; i++) {
                var tdProfesor = tr[i].getElementsByTagName('td')[1];
                var tdProfesion = tr[i].getElementsByTagName('td')[2];
                var tdCarrera = tr[i].getElementsByTagName('td')[3];
                var tdGrado = tr[i].getElementsByTagName('td')[4];
                var tdMateria = tr[i].getElementsByTagName('td')[5];

                if (tdProfesor && tdProfesion && tdCarrera && tdGrado && tdMateria) {
                    var textProfesor = tdProfesor.textContent || tdProfesor.innerText;
                    var textProfesion = tdProfesion.textContent || tdProfesion.innerText;
                    var textCarrera = tdCarrera.textContent || tdCarrera.innerText;
                    var textGrado = tdGrado.textContent || tdGrado.innerText;
                    var textMateria = tdMateria.textContent || tdMateria.innerText;

                    if (textProfesor.toLowerCase().indexOf(filtroProfesor) > -1 &&
                        textProfesion.toLowerCase().indexOf(filtroProfesion
                        textCarrera.toLowerCase().indexOf(filtroCarrera) > -1 &&
                        textGrado.toLowerCase().indexOf(filtroGrado) > -1 &&
                        textMateria.toLowerCase().indexOf(filtroMateria) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        document.getElementById('filtroProfesor').addEventListener('change', filtrarTabla);
        document.getElementById('filtroProfesion').addEventListener('change', filtrarTabla);
        document.getElementById('filtroCarrera').addEventListener('change', filtrarTabla);
        document.getElementById('filtroGrado').addEventListener('change', filtrarTabla);
        document.getElementById('filtroMateria').addEventListener('change', filtrarTabla);
    </script>
</body>
</html>

<?php
$conn->close();
?>
