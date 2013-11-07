<?php

include("imdb_utils.php");
include("connect.php");

class Updater
{
	public function Update()
	{
		$query =  "SELECT const FROM Films WHERE updated is null";
		$result = mysql_query($query);
		// $query_upd_

		$imdb_Utils = new ImdbUtils();

		while ($row = mysql_fetch_array($result)) {

			// $movieArray = $imdb->getMovieInfoById($row['const'],false) ;
			$movieArray = $imdb_Utils->scrapeMovieInfo($row['const'],false);

			// file_put_contents($output, file_get_contents(".\\posters\\big\\".$row['const'].".jpg","imdbImage.php?url=\<\?=".$movieArray['poster_large']."\?\>"));

		

			$stars = $movieArray['stars'];

			foreach($stars as $x=>$x_value)
			  {

			  	$result_actor = mysql_query("SELECT actor_id FROM actors WHERE actor_id = '".$x."'");

			  	// print_r($result_actor);

			  	$n = mysql_num_rows($result_actor);

			  	// echo "count: ".$n;

			  	if($n == 0)
			  	{
			  		mysql_query("INSERT INTO Actors VALUES ('$x', '$x_value')");
			  	}

			  	mysql_query("INSERT INTO Starring VALUES ('".$row['const']."','$x')");

			  }

			mysql_query("UPDATE Films SET updated = b'1' WHERE const = '".$row['const']."'");

			// echo "<div>".$stars[0]."</div>";
			// echo "<div><img src=\"imdbImage.php?url=<?=".$movieArray['poster'].">\"/></div>";

		}

	}
}

?>