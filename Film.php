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
include("imdb.php");


$imdb = new Imdb();
$movieArray = $imdb->getMovieInfoById($id,false) ;
 
$constructs =" SELECT * FROM Films WHERE const = '$id' ";

$reg = mysql_query($constructs);
$row = mysql_fetch_row($reg);
$Filmdb = substr($row[0],2);

echo "<table>";
echo "<tr>";
echo "<td>";

echo "<div  class=\"datagrid\"  >";
echo "<table> "; 
echo "<tr>";
echo        "<td rowspan=\"9\">";
?>
<img src="imdbImage.php?url=<?=$movieArray['poster']?>" />
<?php
echo "</td>";
echo        "<td rowspan=\"9\"> &nbsp &nbsp</td>";
echo    "</tr>";
echo    "<tr>";
echo        "<td><b>Title: </b>$row[1]&nbsp &nbsp</td>";
echo    "</tr>";
echo    "<tr>";
echo        "<td><b>Director: </b>$row[3]&nbsp &nbsp</td>";
echo    "</tr>";
echo    "<tr>";
echo        "<td><b>IMDb Rating: </b>$row[4]</td>";
echo    "</tr>";
echo    "<tr>";
echo        "<td><b>Runtime: </b>$row[5] min</td>";
echo    "</tr>";
echo    "<tr>";
echo        "<td><b>Genre: </b>$row[6]&nbsp &nbsp</td>";
echo    "</tr>";
echo    "<tr>";
echo        "<td><b>Year: </b>$row[7]</td>";
echo    "</tr>";
echo    "<tr>";
echo        "<td><b>Total votes: </b>$row[8]</td>";
echo    "</tr>";
echo    "<tr>";
echo        "<td><a href=$row[9]>More Info</a></td>";
echo    "</tr>";
echo "</table>";
echo "</div>";
echo "</td>";
echo "<td>";


$user ="SELECT Name, Rate AS Rating, Modified AS DATE FROM Users NATURAL JOIN Rates WHERE const = '$id'";
$reg1 = mysql_query($user);
echo "<div class=\"CSSTableGenerator\"  >";
echo "<table> \n";
echo "<tr>";
echo "<td>Name</td>";
echo "<td>Rating</td>";
echo "<td>DATE</td>";
echo "</tr>";

while($row1 = mysql_fetch_row($reg1))
{
echo "<tr>";
echo    "<td>$row1[0]</td>";
echo    "<td>$row1[1]</td>";
echo    "<td>$row1[2]</td>";
echo "</tr>";
}

echo "</table>";
echo "</div>";
echo "</td>";
echo "</tr>";
echo "</table>";
?>



</div>
<?php include("Footer.php"); ?>
</body>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44939808-1', 'ratinghood.com');
  ga('send', 'pageview');

</script>
</html> 
