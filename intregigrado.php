<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $grado = $_POST['grado'];
    $descripcion = $_POST['descri'];

    // Verificar si el grado ya existe en la tabla Grado
    $sql_check = "SELECT id FROM Grado WHERE grado = ? AND descripcion = ?";
    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param("ss", $grado, $descripcion);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // El grado ya existe, actualizamos el registro
            $sql_update = "UPDATE Grado SET descripcion = ? WHERE grado = ?";
            if ($stmt_update = $conn->prepare($sql_update)) {
                $stmt_update->bind_param("ss", $descripcion, $grado);
                if ($stmt_update->execute()) {
                    echo "Actualización de grado exitosa!";
                } else {
                    echo "Error al actualizar el grado: " . $stmt_update->error;
                }
                $stmt_update->close();
            } else {
                echo "Error al preparar la consulta de actualización: " . $conn->error;
            }
        } else {
            // El grado no existe, insertamos un nuevo registro
            $sql_insert = "INSERT INTO Grado (grado, descripcion) VALUES (?, ?)";
            if ($stmt_insert = $conn->prepare($sql_insert)) {
                $stmt_insert->bind_param("ss", $grado, $descripcion);
                if ($stmt_insert->execute()) {
                    echo "Registro de grado exitoso!";
                } else {
                    echo "Error al registrar el grado: " . $stmt_insert->error;
                }
                $stmt_insert->close();
            } else {
                echo "Error al preparar la consulta de inserción: " . $conn->error;
            }
        }
        $stmt_check->close();
    } else {
        echo "Error al preparar la consulta de verificación: " . $conn->error;
    }

    $conn->close();
    header('Location: Grado.php');
    exit();
}
?>
