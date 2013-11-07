<!DOCTYPE html>
<html>
<head>
<title>Ratinghood</title>
<link href="Site.css" rel="stylesheet">
</head>

<body>
<?php include("Header.php"); ?>
<div id="main">
  <h1>Films</h1>
  
 
<?php
$id = $_GET ['ID'];

include("connect.php");
 
$constructs =" SELECT * FROM Films WHERE const = '$id' ";

$reg = mysql_query($constructs);
echo "<div class=\"CSSTableGenerator\" >";
echo "<table> \n";  //EMPIEZA A CREAR LA TABLA CON LOS ENCABEZADOS DE TABLA
echo "<tr>";//<tr> CREA UNA NUEVA FILA
echo "<td>Poster</td>";
echo "<td>Title</td>";//<td> CREA NUEVA COLUMNA
echo "<td>Director</td>";
echo "<td>IMDb_Rating</td>";
echo "<td>Runtime</td>";
echo "<td>Genre</td>";
echo "<td>Year</td>";
echo "<td>Total_votes</td>";
echo "<td>More Info</td>";


echo "</tr>";
while($row = mysql_fetch_row($reg))
{
echo "<tr>";


 $Filmdb = substr($row[0],2);
echo "<td><script type=\"text/javascript\"
  src=\"http://www.movieposterdb.com/embed.inc.php?movie_id=$Filmdb\">
</script></td>";


echo "<td>$row[1]</td>";
echo "<td>$row[3]</td>";
echo "<td>$row[4]</td>";
echo "<td>$row[5]</td>";
echo "<td>$row[6]</td>";
echo "<td>$row[7]</td>";
echo "<td>$row[8]</td>";
echo "<td><a href=$row[9]>More Info</a></td> \n";




echo "</tr>";
}
echo "</table>";//FINALIZA LA TABLA
echo "</div>";


echo "  <h1>Users</h1>";

$user ="SELECT Name, Rate AS Rating, Modified AS DATE FROM Users NATURAL JOIN Rates WHERE const = '$id'";

$reg1 = mysql_query($user);
echo "<div class=\"CSSTableGenerator\" >";
echo "<table> \n";  //EMPIEZA A CREAR LA TABLA CON LOS ENCABEZADOS DE TABLA
echo "<tr>";//<tr> CREA UNA NUEVA FILA
echo "<td>Name</td>";
echo "<td>Rating</td>";//<td> CREA NUEVA COLUMNA
echo "<td>DATE</td>";
echo "</tr>";

while($row1 = mysql_fetch_row($reg1))
{
echo "<tr>";
echo "<td>$row1[0]</td>";
echo "<td>$row1[1]</td>";
echo "<td>$row1[2]</td>";


echo "</tr>";
}
echo "</table>";
echo "</div>";

?>


<?php include("search.php"); ?>
</div>
<?php include("Footer.php"); ?>
</body>
</html> 