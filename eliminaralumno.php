<?php
include "conexion.php";

$id = $_GET['id'];

$conn -> query("DELETE FROM est WHERE id ='". $id."'");
header('Location:regialum.php');
?>