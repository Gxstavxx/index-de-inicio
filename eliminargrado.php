<?php
include "conexion.php";

$id = $_GET['id'];

$conn -> query("DELETE FROM grado WHERE id ='". $id."'");
header('Location:Grado.php');
?>