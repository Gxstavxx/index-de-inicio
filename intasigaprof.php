<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profesor_id = $_POST['profesor_id'];
    $profesion = $_POST['profesion']; // Usar el campo oculto con el nuevo nombre
    $nickname = $_POST['nickname']; // Usar el campo oculto con el nuevo nombre
    $carrera_id = $_POST['carrera_id'];
    $grado_id = $_POST['grado_id'];
    $curso_id = $_POST['curso_id'];

    // Obtener los nombres del profesor
    $sqlProf = "SELECT nombres, apellidos FROM prof WHERE id = ?";
    if ($stmt = $conn->prepare($sqlProf)) {
        $stmt->bind_param("i", $profesor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $professor = $result->fetch_assoc();
        $docente = $professor['nombres'] . ' ' . $professor['apellidos'];
        $stmt->close();
    }

    // Verificar si la asignación ya existe en la base de datos
    $sqlCheck = "SELECT * FROM cursoasig WHERE Docente = ? AND paraqcar = ? AND paraqgra = ? AND cursig = ?";
    $stmt = $conn->prepare($sqlCheck);
    $stmt->bind_param("siii", $docente, $carrera_id, $grado_id, $curso_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        $conn->close();
        header("Location: regiasignaprof.php?error=" . urlencode("La asignación ya existe") . "&profesor_id=" . urlencode($profesor_id) . "&carrera_id=" . urlencode($carrera_id) . "&grado_id=" . urlencode($grado_id) . "&curso_id=" . urlencode($curso_id));
        exit();
    } else {
        $stmt->close();
        // Insertar el nuevo registro en la tabla CursoAsignado
        $sqlInsert = "INSERT INTO cursoasig (Docente, paraqcar, paraqgra, Profesion, Nickname, cursig) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlInsert);
        $stmt->bind_param("sisssi", $docente, $carrera_id, $grado_id, $profesion, $nickname, $curso_id);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: Asigprof.php?success=" . urlencode("Asignación realizada correctamente"));
            exit();
        } else {
            $error_message = "Error al insertar el registro: " . $stmt->error;
            $stmt->close();
            $conn->close();
            header("Location: regiasignaprof.php?error=" . urlencode($error_message) . "&profesor_id=" . urlencode($profesor_id) . "&carrera_id=" . urlencode($carrera_id) . "&grado_id=" . urlencode($grado_id) . "&curso_id=" . urlencode($curso_id));
            exit();
        }
    }
}
?>
