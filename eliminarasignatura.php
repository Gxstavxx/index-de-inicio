<?php
include "conexion.php";

$id = $_GET['id'];

$conn -> query("DELETE FROM carrera WHERE id ='". $id."'");
header('Location:asignatura.php');
?>