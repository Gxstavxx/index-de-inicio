<?php
include 'conexion.php';

// Manejar la acción del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $search = $_POST['search']; // ID del profesor seleccionado
    $profesion = $_POST['profesion']; // Profesión del profesor
    $paraqcar = $_POST['paraqcar']; // ID de la carrera seleccionada
    $paraqgra = $_POST['paraqgra']; // ID del grado seleccionado
    $materia = $_POST['materia']; // ID de la materia seleccionada

    // Obtener los nombres del profesor
    $sqlProf = "SELECT nombres, apellidos FROM prof WHERE id = ?";
    if ($stmt = $conn->prepare($sqlProf)) {
        $stmt->bind_param("i", $search);
        $stmt->execute();
        $result = $stmt->get_result();
        $professor = $result->fetch_assoc();
        $docente = $professor['nombres'] . ' ' . $professor['apellidos'];
        $stmt->close();
    }

    // Obtener el nombre de la carrera
    $sqlCarr = "SELECT Carrera FROM Carrera WHERE id = ?";
    if ($stmt = $conn->prepare($sqlCarr)) {
        $stmt->bind_param("i", $paraqcar);
        $stmt->execute();
        $result = $stmt->get_result();
        $carrera = $result->fetch_assoc()['Carrera'];
        $stmt->close();
    }

    // Obtener el nombre del grado
    $sqlGrad = "SELECT grado FROM Grado WHERE id = ?";
    if ($stmt = $conn->prepare($sqlGrad)) {
        $stmt->bind_param("i", $paraqgra);
        $stmt->execute();
        $result = $stmt->get_result();
        $grado = $result->fetch_assoc()['grado'];
        $stmt->close();
    }

    // Obtener el nombre de la materia
    $sqlCurso = "SELECT Materia FROM CursoAsignado WHERE id = ?";
    if ($stmt = $conn->prepare($sqlCurso)) {
        $stmt->bind_param("i", $materia);
        $stmt->execute();
        $result = $stmt->get_result();
        $materiaNombre = $result->fetch_assoc()['Materia'];
        $stmt->close();
    }

    // Insertar en la tabla CursoAsig
    $sql = "INSERT INTO CursoAsig (Docente, Profesion, paraqcar, paraqgra, cursig) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $docente, $profesion, $carrera, $grado, $materiaNombre);
        if ($stmt->execute()) {
            // Redirigir a la página de asignación de profesor después de la inserción exitosa
            header('Location: asigprof.php');
            exit();
        } else {
            echo "Error al registrar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    $conn->close();
}
?>
