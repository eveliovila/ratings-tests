<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="Site.css">
</head>
<body>
<?php include("Header.php"); ?>
<div id="main">
<h1>Users</h1>
<?php
include("connect.php"); 
$query = "SELECT Name from Users order by Users.Name ";
$result = mysql_query($query,$conexion);


print "<SELECT name=Peliculas>"; 
   while ($line = mysql_fetch_array($result)) 
   { 
      foreach ($line as $value) 
       { 
         print "<OPTION value='$value'"; 
      } 
print ">$value</OPTION>"; 
   } 
    mysql_close($conexion); 
print "</SELECT>"; 


?>




</div>
<?php include("Footer.php"); ?>
</body>
</html> 