<?php
include "conexion.php";

$nombre= $_POST ['nombre'];
$producto= $_POST ['producto'];
$precio = $_POST ['precio'];
$cantidad = $_POST ['cantidad'];

$sql= $conn-> query("INSERT INTO productos( nombre_de_producto,descripcion_de_producto,precio,cantidad) VALUES ('$nombre','$producto','$precio','$cantidad')");
header ('Location: listar.php');
?>