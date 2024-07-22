<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $grado = $_POST['grado'];
    $carrera_id = $_POST['selectcarrera']; // Obtiene el ID de la carrera seleccionada

    // Verificar si el grado ya existe en la tabla Grado
    $sql_check = "SELECT id FROM Grado WHERE grado = ? AND carreraselec = ?";
    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param("si", $grado, $carrera_id);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // El grado ya existe
            $errorMsg = "El grado ya existe para la carrera seleccionada.";
            $stmt_check->close();
            include 'registro_grado.php'; // Asegúrate de que 'registro_grado.php' contiene el código HTML del formulario
        } else {
            // Insertar nuevo registro
            $sql_insert = "INSERT INTO Grado (grado, carreraselec) VALUES (?, ?)";
            if ($stmt_insert = $conn->prepare($sql_insert)) {
                $stmt_insert->bind_param("si", $grado, $carrera_id);
                if ($stmt_insert->execute()) {
                    $stmt_insert->close();
                    $stmt_check->close();
                    $conn->close();
                    header('Location: Grado.php');
                    exit(); // Asegurarse de que el script se detenga después de la redirección
                } else {
                    $errorMsg = "Error al registrar el grado: " . $stmt_insert->error;
                    $stmt_insert->close();
                    $stmt_check->close();
                    include 'registro_grado.php';
                }
            } else {
                $errorMsg = "Error al preparar la consulta de inserción: " . $conn->error;
                $stmt_check->close();
                include 'regigrado.php';
            }
        }
    } else {
        $errorMsg = "Error al preparar la consulta de verificación: " . $conn->error;
        include 'regigrado.php';
    }

    // Cerrar la conexión solo si no se ha redirigido antes
    if ($conn->connect_errno == 0) {
      
    }
}
?>
