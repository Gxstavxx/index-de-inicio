<?php
include "conexion.php";

$id = $_GET['id'];

$conn -> query("DELETE FROM cursoasignado WHERE id ='". $id."'");
header('Location:Cursos.php');
?>