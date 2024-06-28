<?php
include "conexion.php";

$id = $_GET['id'];

$conn -> query("DELETE FROM asig WHERE id ='". $id."'");
header('Location:asignatura.php');
?>