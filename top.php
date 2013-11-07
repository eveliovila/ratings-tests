
<!DOCTYPE html>

<html>
<head>
  <title>Top rated movies</title>
  <link href="Site.css" rel="stylesheet">
</head>

<body>
<?php include("Header.php"); ?>
<div id="main">

<?php

include("connect.php");
// include("imdb.php");
include("imdb_utils.php");

// include("get_posters_actors.php");
// $upd = new Updater();
// $upd->Update();

$query =  "SELECT count(*) as user_count FROM Users";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

// echo "users: ".$row['user_count']."<br>";

$query =  "select const, Title, count(*) as c from Rates NATURAL JOIN Films group by const having c > ".$row['user_count']." - 2 order by c desc";
$result = mysql_query($query);
// $count_rows = mysql_num_rows($result);

// echo "$count_rows <br>";

// $imdb = new Imdb();
$imdbUtils = new ImdbUtils();

$row = mysql_fetch_array($result);
$count = $row['c'];
$movies_per_row = 3;
$i = 1;

echo "<h2>Top rated movies</h2></br>";


echo "<table><tr><td>".$count."</td></tr>";
//echo "<tr><td><hr size='1'></td></tr>";
echo "<tr>";

while ($row) {
	if($row['c'] != $count)
	{
		echo "</tr>";
		echo "<tr><td><br></td></tr>";	//empty row
		$count = $row['c'];
		$i = 1;
		echo "<tr><td>".$count."</td></tr>";
		//echo "<tr><td><hr size='1'></td></tr>";
		echo "<tr>";

	}
	echo "<td><div>";
	// poster
	// echo "<div><script type=\"text/javascript\" src=\"http://www.movieposterdb.com/embed.inc.php?movie_id=".substr($row['const'],2)."\"></script></div>";
	// $movieArray = $imdb->getMovieInfoById($row['const'],false) ;
	$movieArray = $imdbUtils->scrapeMovieInfo($row['const'],false)
	?>
	<div><img src="imdbImage.php?url=<?=$movieArray['poster_large']?>"/></div>
	
	<?php
	// $stars = $movieArray['stars'];
	// echo count($stars);
	// print_r($stars);

	// foreach($stars as $x=>$x_value)
	//   {
	//   echo "Key=" . $x . ", Value=" . $x_value;
	//   echo "<br>";
	//   }

	// echo "<div>".$stars[0]."</div>";
	// echo "<div><img src=\"imdbImage.php?url=<?=".$movieArray['poster'].">\"/></div>";

	echo "<div><a href=\"http://ratinghood.com/Film.php?ID=".$row['const']."\">".$row['Title']."</a></div>";
	echo "</div></td>";	

	if($i % $movies_per_row == 0)
	{
		echo "<tr><td><br></td></tr>";
		echo "<tr>";
	}

	$row = mysql_fetch_array($result);
	$i ++;
}

echo "</tr></table>";

?>

</div>
</body>

</html>
