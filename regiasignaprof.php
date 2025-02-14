<?php
include 'conexion.php';

// Obtener todos los profesores junto con su profesión y nickname
$sqlProf = "SELECT id, nombres, apellidos, profesion, nickname FROM prof";
$resultProf = $conn->query($sqlProf);

// Obtener todas las carreras
$sqlCarr = "SELECT id, Carrera FROM Carrera";
$resultCarr = $conn->query($sqlCarr);

// Obtener todos los grados
$sqlGrad = "SELECT id, grado FROM Grado";
$resultGrad = $conn->query($sqlGrad);

// Obtener todos los cursos (materias)
$sqlCurso = "SELECT id, Materia FROM CursoAsignado";
$resultCurso = $conn->query($sqlCurso);

// Capturar el mensaje de error de la URL si existe
$error_message = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4 text-center">Asignar Profesor</h2>
                        <?php if ($error_message): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        <form action="intasigaprof.php" method="post" id="assign-form">
                            <!-- Campo oculto para ID de Carrera -->
                            <input type="hidden" name="carrera_id" value="<?php echo isset($_GET['carrera_id']) ? htmlspecialchars($_GET['carrera_id']) : ''; ?>">

                            <div class="mb-3">
                                <label for="search" class="form-label">Seleccionar Profesor</label>
                                <select id="search" name="profesor_id" class="form-select" required onchange="updateProfesionAndNickname()">
                                    <option value="">Seleccione un profesor</option>
                                    <?php while ($row = $resultProf->fetch_assoc()) { ?>
                                        <option value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>" data-profesion="<?php echo htmlspecialchars($row['profesion'], ENT_QUOTES, 'UTF-8'); ?>" data-nickname="<?php echo htmlspecialchars($row['nickname'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars($row['nombres'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($row['apellidos'], ENT_QUOTES, 'UTF-8') . ' (' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ')'; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="profesion" class="form-label">Profesión</label>
                                <input type="text" id="profesion" name="profesion" class="form-control" readonly required>
                                <input type="hidden" id="hidden_profesion" name="hidden_profesion">
                            </div>
                            <div class="mb-3">
                                <label for="nickname" class="form-label">Nickname</label>
                                <input type="text" id="nickname" name="nickname" class="form-control" readonly required>
                            </div>

                            <div class="mb-3">
                                <label for="paraqcar" class="form-label">Para qué Carrera</label>
                                <select id="paraqcar" name="carrera_id" class="form-select" required onchange="updateCarrera()">
                                    <option value="">Seleccione una carrera</option>
                                    <?php while ($row = $resultCarr->fetch_assoc()) { ?>
                                        <option value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($row['Carrera'], ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php } ?>
                                </select>
                                <input type="text" id="selectedCarrera" name="selectedCarrera" class="form-control mt-2" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="paraqgra" class="form-label">Para qué Grado</label>
                                <select id="paraqgra" name="grado_id" class="form-select" required onchange="updateGrado()">
                                    <option value="">Seleccione un grado</option>
                                    <?php while ($row = $resultGrad->fetch_assoc()) { ?>
                                        <option value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($row['grado'], ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php } ?>
                                </select>
                                <input type="text" id="selectedGrado" name="selectedGrado" class="form-control mt-2" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="materia" class="form-label">Materia Asignada</label>
                                <select id="materia" name="curso_id" class="form-select" required onchange="updateMateria()">
                                    <option value="">Seleccione una materia</option>
                                    <?php while ($row = $resultCurso->fetch_assoc()) { ?>
                                        <option value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($row['Materia'], ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php } ?>
                                </select>
                                <input type="text" id="selectedMateria" name="selectedMateria" class="form-control mt-2" readonly>
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
        function updateProfesionAndNickname() {
            const select = document.getElementById('search');
            const profesionInput = document.getElementById('profesion');
            const hiddenProfesion = document.getElementById('hidden_profesion');
            const nicknameInput = document.getElementById('nickname');
            const selectedOption = select.options[select.selectedIndex];
            const profesion = selectedOption.getAttribute('data-profesion');
            const nickname = selectedOption.getAttribute('data-nickname');
            profesionInput.value = profesion;
            hiddenProfesion.value = profesion;
            nicknameInput.value = nickname;
        }

        function updateCarrera() {
            const select = document.getElementById('paraqcar');
            const selectedCarrera = document.getElementById('selectedCarrera');
            selectedCarrera.value = select.options[select.selectedIndex].text;
        }

        function updateGrado() {
            const select = document.getElementById('paraqgra');
            const selectedGrado = document.getElementById('selectedGrado');
            selectedGrado.value = select.options[select.selectedIndex].text;
        }

        function updateMateria() {
            const select = document.getElementById('materia');
            const selectedMateria = document.getElementById('selectedMateria');
            selectedMateria.value = select.options[select.selectedIndex].text;
        }

        window.addEventListener('DOMContentLoaded', (event) => {
            updateProfesionAndNickname();
            updateCarrera();
            updateGrado();
            updateMateria();
        });
    </script>
</body>
</html>
