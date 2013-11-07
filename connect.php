<?php


$db_host=""; 
$db_usuario=""; 
$db_password=""; 
$db_nombre=""; 

$conexion = @mysql_connect($db_host, $db_usuario, $db_password) or die(mysql_error()); 
$db = @mysql_select_db($db_nombre, $conexion) or die(mysql_error()); 
?> 
