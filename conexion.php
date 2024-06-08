<?php
$sn = "localhost"; 
$db = "registro2";
$user= "root";
$pass = "";

$conn = mysqli_connect ($sn,$user,$pass,$db);
if (!$conn){
die ("Error: ". mysqli_connect_error());


}

?>