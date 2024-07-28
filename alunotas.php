<?php
include "conexion.php";

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recorre cada id de estudiante y procesa los datos correspondientes
    foreach ($_POST['p1'] as $id => $p1) {
        // Obtener los demás valores
        $p2 = $_POST['p2'][$id];
        $p3 = $_POST['p3'][$id];
        $p4 = $_POST['p4'][$id];
        $examen = $_POST['examen'][$id];

        // Obtener los detalles del estudiante, incluyendo los nombres de grado y carrera
        $query = "
            SELECT e.nombres, 
                   e.apellidos, 
                   g.grado AS grado, 
                   c.carrera AS carrera 
            FROM est e
            LEFT JOIN Grado g ON e.grado = g.id
            LEFT JOIN Carrera c ON e.carrera = c.id
            WHERE e.id = ?
        ";
        $stmt_get = $conn->prepare($query);
        $stmt_get->bind_param("i", $id);
        $stmt_get->execute();
        $result = $stmt_get->get_result();
        $student = $result->fetch_assoc();
        $nombres = $student['nombres'];
        $apellidos = $student['apellidos'];
        $grado = $student['grado'];
        $carrera = $student['carrera'];

        // Evaluar y actualizar cada campo individualmente
        if (!empty($p1)) {
            // Verificar si el registro ya existe en la tabla notasp1
            $query_check = "SELECT id FROM notasp1 WHERE carrera = ? AND p1 = ?";
            $stmt_check = $conn->prepare($query_check);
            $stmt_check->bind_param("ss", $carrera, $p1);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows === 0) {
                // Insertar los datos en la tabla notasp1
                $stmt = $conn->prepare("INSERT INTO notasp1 (nombres, apellidos, grado, carrera, p1) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $nombres, $apellidos, $grado, $carrera, $p1);
                try {
                    $stmt->execute();
                } catch (mysqli_sql_exception $e) {
                    // Manejo de errores si ocurre un problema de duplicado
                    if ($e->getCode() == 1062) {
                        // Código de error para duplicado
                        // Puedes registrar el error o manejarlo de alguna manera
                    } else {
                        throw $e; // Si no es un error de duplicado, relanza el error
                    }
                }
                $stmt->close();
            }
            $stmt_check->close();
        }

        if (!empty($p2)) {
            // Verificar si el registro ya existe en la tabla notasp2
            $query_check = "SELECT id FROM notasp2 WHERE carrera = ? AND p2 = ?";
            $stmt_check = $conn->prepare($query_check);
            $stmt_check->bind_param("ss", $carrera, $p2);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows === 0) {
                // Insertar los datos en la tabla notasp2
                $stmt = $conn->prepare("INSERT INTO notasp2 (nombres, apellidos, grado, carrera, p2) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $nombres, $apellidos, $grado, $carrera, $p2);
                try {
                    $stmt->execute();
                } catch (mysqli_sql_exception $e) {
                    if ($e->getCode() == 1062) {
                        // Manejo de error
                    } else {
                        throw $e;
                    }
                }
                $stmt->close();
            }
            $stmt_check->close();
        }

        if (!empty($p3)) {
            // Verificar si el registro ya existe en la tabla notasp3
            $query_check = "SELECT id FROM notasp3 WHERE carrera = ? AND p3 = ?";
            $stmt_check = $conn->prepare($query_check);
            $stmt_check->bind_param("ss", $carrera, $p3);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows === 0) {
                // Insertar los datos en la tabla notasp3
                $stmt = $conn->prepare("INSERT INTO notasp3 (nombres, apellidos, grado, carrera, p3) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $nombres, $apellidos, $grado, $carrera, $p3);
                try {
                    $stmt->execute();
                } catch (mysqli_sql_exception $e) {
                    if ($e->getCode() == 1062) {
                        // Manejo de error
                    } else {
                        throw $e;
                    }
                }
                $stmt->close();
            }
            $stmt_check->close();
        }

        if (!empty($p4)) {
            // Verificar si el registro ya existe en la tabla notasp4
            $query_check = "SELECT id FROM notasp4 WHERE carrera = ? AND p4 = ?";
            $stmt_check = $conn->prepare($query_check);
            $stmt_check->bind_param("ss", $carrera, $p4);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows === 0) {
                // Insertar los datos en la tabla notasp4
                $stmt = $conn->prepare("INSERT INTO notasp4 (nombres, apellidos, grado, carrera, p4) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $nombres, $apellidos, $grado, $carrera, $p4);
                try {
                    $stmt->execute();
                } catch (mysqli_sql_exception $e) {
                    if ($e->getCode() == 1062) {
                        // Manejo de error
                    } else {
                        throw $e;
                    }
                }
                $stmt->close();
            }
            $stmt_check->close();
        }

        if (!empty($examen)) {
            // Verificar si el registro ya existe en la tabla notasex
            $query_check = "SELECT id FROM notasex WHERE carrera = ? AND Examen = ?";
            $stmt_check = $conn->prepare($query_check);
            $stmt_check->bind_param("ss", $carrera, $examen);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows === 0) {
                // Insertar los datos en la tabla notasex
                $stmt = $conn->prepare("INSERT INTO notasex (nombres, apellidos, grado, carrera, Examen) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $nombres, $apellidos, $grado, $carrera, $examen);
                try {
                    $stmt->execute();
                } catch (mysqli_sql_exception $e) {
                    if ($e->getCode() == 1062) {
                        // Manejo de error
                    } else {
                        throw $e;
                    }
                }
                $stmt->close();
            }
            $stmt_check->close();
        }

        // Insertar el TOTAL en la tabla notastot
        $total = $p1 + $p2 + $p3 + $p4 + $examen;
        $query_check_total = "SELECT id FROM notastot WHERE carrera = ? AND TOTAL = ?";
        $stmt_check_total = $conn->prepare($query_check_total);
        $stmt_check_total->bind_param("ss", $carrera, $total);
        $stmt_check_total->execute();
        $stmt_check_total->store_result();

        if ($stmt_check_total->num_rows === 0) {
            $stmt_total = $conn->prepare("INSERT INTO notastot (nombres, apellidos, grado, carrera, TOTAL) VALUES (?, ?, ?, ?, ?)");
            $stmt_total->bind_param("sssss", $nombres, $apellidos, $grado, $carrera, $total);
            try {
                $stmt_total->execute();
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() == 1062) {
                    // Manejo de error
                } else {
                    throw $e;
                }
            }
            $stmt_total->close();
        }
        $stmt_check_total->close();
    }

    // Cerrar la conexión
    $conn->close();

    // Redirigir a una página de éxito o mostrar un mensaje
    header("Location: alunotas.php");
    exit();
}
?>
