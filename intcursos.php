<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php'; 

    $carrera = $_POST['carrera'];
    $descripcion = $_POST['descripcion'];

    // Insertar en la tabla Carrera y obtener el ID generado
    $sql1 = "INSERT INTO Carrera (carrera, descripcion) VALUES (?, ?)";
    if ($stmt1 = $conn->prepare($sql1)) {
        $stmt1->bind_param("ss", $carrera, $descripcion);
        if ($stmt1->execute()) {
            $last_id = $stmt1->insert_id; // Obtener el último ID insertado
            echo "Registro de carrera exitoso!";
        } else {
            echo "Error al registrar carrera: " . $stmt1->error;
        }
        $stmt1->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

   

    $conn->close();
    header('Location: asignatura.php');
    exit();
}
?>
