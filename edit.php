<?php
include "conexion.php";
$id = $_GET['id'];
$nombre= $_POST ['nombre'];
$descripcion= $_POST ['descripcion'];
$precio = $_POST ['precio'];
$cantidad = $_POST ['cantidad'];
$sql= $conn-> query("UPDATE  productos SET nombre_de_producto ='". $nombre."', descripcion_de_producto ='". $descripcion."', precio ='". $precio."',cantidad ='". $cantidad."' WHERE id = '". $id."'");
if($sql == 1){
    header('Location:listar.php');
}

?> 