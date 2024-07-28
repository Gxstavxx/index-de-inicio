<?php
include "conexion.php";

// Consultas para obtener datos existentes de las tablas
$query_p1 = "SELECT id, p1 FROM notasp1";
$query_p2 = "SELECT id, p2 FROM notasp2";
$query_p3 = "SELECT id, p3 FROM notasp3";
$query_p4 = "SELECT id, p4 FROM notasp4";
$query_examen = "SELECT id, Examen FROM notasex";

$result_p1 = $conn->query($query_p1);
$result_p2 = $conn->query($query_p2);
$result_p3 = $conn->query($query_p3);
$result_p4 = $conn->query($query_p4);
$result_examen = $conn->query($query_examen);

// Convertir resultados en arrays asociativos
$p1_data = [];
$p2_data = [];
$p3_data = [];
$p4_data = [];
$examen_data = [];

while ($row = $result_p1->fetch_assoc()) {
    $p1_data[$row['id']] = $row['p1'];
}
while ($row = $result_p2->fetch_assoc()) {
    $p2_data[$row['id']] = $row['p2'];
}
while ($row = $result_p3->fetch_assoc()) {
    $p3_data[$row['id']] = $row['p3'];
}
while ($row = $result_p4->fetch_assoc()) {
    $p4_data[$row['id']] = $row['p4'];
}
while ($row = $result_examen->fetch_assoc()) {
    $examen_data[$row['id']] = $row['Examen'];
}

// Consulta principal para obtener los datos de los alumnos
$query = "
    SELECT e.id, 
           e.nombres, 
           e.apellidos, 
           g.grado AS grado, 
           c.carrera AS carrera 
    FROM est e
    LEFT JOIN Grado g ON e.grado = g.id
    LEFT JOIN Carrera c ON e.carrera = c.id
"; 

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTA DE ALUMNOS</title>
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
        .btn-group .form-control {
            margin-left: 10px;
            width: 600px; /* Ajusta este valor según sea necesario */
        }
        .actions {
            text-align: center;
        }
        /* Estilo para campos de entrada pequeños */
        .form-control-sm {
            max-width: 80px; /* Ajusta este valor según sea necesario */
            width: 100%;
        }
        .btn-container {
            display: flex;
            justify-content: flex-end;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center mb-4">REGISTRO DE NOTAS</h1>

                <div class="card">
                    <div class="card-body">
                        <div class="btn-group btn-group-sm mb-3" role="group">
                            <a href="interfazdocentes.php" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Regresar</a>
                            <a href="cerrar.php" class="btn btn-danger">Cerrar Sesión</a>
                        </div>
                        <form action="intalunotas.php" method="post">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Grado</th>
                <th scope="col">Carrera</th>
                <th scope="col">P1</th>
                <th scope="col">P2</th>
                <th scope="col">P3</th>
                <th scope="col">P4</th>
                <th scope="col">Examen</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($dat = $result->fetch_object()) {
                    // Obtener datos de notas
                    $p1 = isset($p1_data[$dat->id]) ? $p1_data[$dat->id] : 0;
                    $p2 = isset($p2_data[$dat->id]) ? $p2_data[$dat->id] : 0;
                    $p3 = isset($p3_data[$dat->id]) ? $p3_data[$dat->id] : 0;
                    $p4 = isset($p4_data[$dat->id]) ? $p4_data[$dat->id] : 0;
                    $examen = isset($examen_data[$dat->id]) ? $examen_data[$dat->id] : 0;
            ?>
                <tr>
                    <td><?php echo $dat->id; ?></td>
                    <td><?php echo htmlspecialchars($dat->nombres, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($dat->apellidos, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($dat->grado, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($dat->carrera, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><input type="number" name="p1[<?php echo $dat->id; ?>]" value="<?php echo htmlspecialchars($p1, ENT_QUOTES, 'UTF-8'); ?>" class="form-control form-control-sm" max="15" data-max="15" /></td>
                    <td><input type="number" name="p2[<?php echo $dat->id; ?>]" value="<?php echo htmlspecialchars($p2, ENT_QUOTES, 'UTF-8'); ?>" class="form-control form-control-sm" max="15" data-max="15" /></td>
                    <td><input type="number" name="p3[<?php echo $dat->id; ?>]" value="<?php echo htmlspecialchars($p3, ENT_QUOTES, 'UTF-8'); ?>" class="form-control form-control-sm" max="15" data-max="15" /></td>
                    <td><input type="number" name="p4[<?php echo $dat->id; ?>]" value="<?php echo htmlspecialchars($p4, ENT_QUOTES, 'UTF-8'); ?>" class="form-control form-control-sm" max="15" data-max="15" /></td>
                    <td><input type="number" name="examen[<?php echo $dat->id; ?>]" value="<?php echo htmlspecialchars($examen, ENT_QUOTES, 'UTF-8'); ?>" class="form-control form-control-sm" max="40" data-max="40" /></td>
                    <td class="total"><span class="total-value">0</span></td>
                </tr>
            <?php
                }
                $result->close(); // Liberar el conjunto de resultados
            } else {
                echo "<tr><td colspan='11'>No hay registros encontrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="btn-container">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </div>
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function calculateTotal() {
            let rows = document.querySelectorAll('#table-body tr');

            rows.forEach(row => {
                let p1 = parseFloat(row.querySelector('input[name^="p1"]').value) || 0;
                let p2 = parseFloat(row.querySelector('input[name^="p2"]').value) || 0;
                let p3 = parseFloat(row.querySelector('input[name^="p3"]').value) || 0;
                let p4 = parseFloat(row.querySelector('input[name^="p4"]').value) || 0;
                let examen = parseFloat(row.querySelector('input[name^="examen"]').value) || 0;

                let total = p1 + p2 + p3 + p4 + examen;

                row.querySelector('.total-value').textContent = total;
            });
        }

        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', calculateTotal);
        });

        calculateTotal();
    </script>
</body>
</html>
