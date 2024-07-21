<?php
include 'conexion.php';

// Manejar la búsqueda de profesores
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $query = "%$query%";
    
    $sql = "SELECT id, nombres, apellidos FROM prof WHERE id LIKE ? OR nombres LIKE ? OR apellidos LIKE ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $query, $query, $query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $professors = [];
        while ($row = $result->fetch_assoc()) {
            $professors[] = $row;
        }
        
        echo json_encode($professors);
        
        $stmt->close();
    } else {
        echo json_encode([]);
    }
    $conn->close();
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ASIGNAR PROFESOR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f0f0f0;
            padding-top: 20px;
        }
        .card {
            margin-top: 6%;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .autocomplete-results {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fff;
            position: absolute;
            width: 100%;
            z-index: 1000;
        }
        .autocomplete-results div {
            padding: 10px;
            cursor: pointer;
        }
        .autocomplete-results div:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4 text-center">Asignar Profesor</h2>
                        <?php if (isset($error_message)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php } ?>
                        <form action="intasigaprof.php" method="post" id="assign-form">
    <!-- Campo oculto para ID de Carrera -->
    <input type="hidden" name="carrera_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">

    <div class="mb-3 position-relative">
        <label for="search" class="form-label">Buscar Profesor</label>
        <input type="text" id="search" name="search" class="form-control" placeholder="Ingrese ID, nombres o apellidos" onkeyup="searchProfessors()" autocomplete="off" required>
        <div id="autocomplete-results" class="autocomplete-results"></div>
    </div>
    <div class="mb-3">
        <label for="materia" class="form-label">Materia Asignada</label>
        <input type="text" name="materia" class="form-control" placeholder="Ingrese la materia" required>
    </div>
    <div class="mb-3">
        <label for="des" class="form-label">Descripción de la Materia Asignada</label>
        <input type="text" name="des" class="form-control" placeholder="Ingrese la descripción" required>
    </div>

    <center>
        <div class="row justify-content-center">
            <div class="col-6">
                <button type="submit" class="btn btn-block btn-outline-primary">Guardar Cambios</button>
            </div>
        </div>
    </center>
</form>

                        <center>
                            <form action="Cursos.php">
                                <div class="col-6">
                                    <center>
                                        <br><button type="submit" class="btn btn-primary btn-block"><i class="fas fa-arrow-left"></i> Regresar</button><br>
                                    </center>
                                </div>
                            </form>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function searchProfessors() {
            let query = document.getElementById('search').value;
            if (query.length > 0) {
                fetch('?query=' + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => {
                        let resultsDiv = document.getElementById('autocomplete-results');
                        resultsDiv.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(professor => {
                                let div = document.createElement('div');
                                div.innerHTML = `${professor.nombres} ${professor.apellidos} (${professor.id})`;
                                div.onclick = function() {
                                    document.getElementById('search').value = `${professor.nombres} ${professor.apellidos}`;
                                    resultsDiv.innerHTML = '';
                                };
                                resultsDiv.appendChild(div);
                            });
                        } else {
                            resultsDiv.innerHTML = '<div>No se encontraron resultados</div>';
                        }
                    });
            } else {
                document.getElementById('autocomplete-results').innerHTML = '';
            }
        }

        // Validación del formulario en el lado del cliente
        document.getElementById('assign-form').addEventListener('submit', function(event) {
            let searchInput = document.getElementById('search').value.trim();
            if (searchInput.length === 0) {
                alert('Por favor, busque y seleccione un profesor.');
                event.preventDefault(); // Evita el envío del formulario
            }
        });
    </script>
</body>
</html>
