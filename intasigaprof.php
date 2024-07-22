<?php
include 'conexion.php';

// Manejar la acción del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $profesor_id = $_POST['profesor_id']; // ID del profesor seleccionado
    $profesion = $_POST['profesion']; // Profesión del profesor
    $carrera_id = $_POST['carrera_id']; // ID de la carrera seleccionada
    $grado_id = $_POST['grado_id']; // ID del grado seleccionado
    $curso_id = $_POST['curso_id']; // ID de la materia seleccionada

    // Obtener los nombres del profesor
    $sqlProf = "SELECT nombres, apellidos FROM prof WHERE id = ?";
    if ($stmt = $conn->prepare($sqlProf)) {
        $stmt->bind_param("i", $profesor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $professor = $result->fetch_assoc();
        $docente = $professor['nombres'] . ' ' . $professor['apellidos'];
        $stmt->close();
    } else {
        echo "Error al preparar la consulta de profesor: " . $conn->error;
        exit();
    }

    // Obtener el nombre de la carrera
    $sqlCarr = "SELECT Carrera FROM Carrera WHERE id = ?";
    if ($stmt = $conn->prepare($sqlCarr)) {
        $stmt->bind_param("i", $carrera_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $carrera = $result->fetch_assoc()['Carrera'];
        } else {
            $carrera = 'Desconocido'; // Valor predeterminado en caso de que no se encuentre
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta de carrera: " . $conn->error;
        exit();
    }

    // Obtener el nombre del grado
    $sqlGrad = "SELECT grado FROM Grado WHERE id = ?";
    if ($stmt = $conn->prepare($sqlGrad)) {
        $stmt->bind_param("i", $grado_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $grado = $result->fetch_assoc()['grado'];
        } else {
            $grado = 'Desconocido'; // Valor predeterminado en caso de que no se encuentre
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta de grado: " . $conn->error;
        exit();
    }

    // Obtener el nombre de la materia
    $sqlCurso = "SELECT Materia FROM CursoAsignado WHERE id = ?";
    if ($stmt = $conn->prepare($sqlCurso)) {
        $stmt->bind_param("i", $curso_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $materiaNombre = $result->fetch_assoc()['Materia'];
        } else {
            $materiaNombre = 'Desconocido'; // Valor predeterminado en caso de que no se encuentre
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta de materia: " . $conn->error;
        exit();
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
        echo "Error al preparar la consulta de inserción: " . $conn->error;
    }

    $conn->close();
}
?>
