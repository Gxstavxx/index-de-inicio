<?php
include "conexion.php";

$id = $_GET['id'];

$conn -> query("DELETE FROM prof WHERE id ='". $id."'");
header('Location:interfaz1.php');
?>