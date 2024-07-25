<?php
include "conexion.php";

$id = $_GET['id'];

$conn -> query("DELETE FROM cursoaig WHERE id ='". $id."'");
header('Location:asigprof.php');
?>