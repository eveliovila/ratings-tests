<?php

    if ($_GET>1)
    {

$button = $_GET ['submit'];
$search = $_GET ['search'];

if(strlen($search)<=1)
echo "";
else
{
echo "You searched for <b>$search</b> <hr size='1'></br>";
include("connect.php");

$search_exploded = explode (" ", $search);
$Newserch=array();

foreach($search_exploded as $search_each)
{

if ($search_each=="the" || $search_each=="The" || $search_each=="ii" || $search_each=="II" || $search_each=="in" || $search_each=="In" || $search_each=="or" ||$search_each=="Or"|| $search_each=="In" || $search_each=="in" || $search_each=="To" ||$search_each=="TO" ||$search_each=="Of" || $search_each=="of" || $search_each=="III" || $search_each=="iii")
{

}
else
array_push($Newserch,$search_each);

}


$construct = "";

$ini ="[[:<:]]";
$fin= "[[:>:]]";
$x=0    ;

foreach($Newserch as $search_each)

{

$x++;
if($x==1)
{

$construct .="Title RLIKE '"  ;
$construct .=$ini;
$construct .=$search_each;
$construct .=$fin;
$construct .="'";
}
else
{
$construct .=" OR Title RLIKE '"  ;
$construct .=$ini;
$construct .=$search_each;
$construct .=$fin;
$construct .="'";

}
  }
$constructs ="SELECT const, Title FROM Films WHERE $construct";

$run = mysql_query($constructs);

$foundnum = mysql_num_rows($run);
include("imdb.php");
$imdb = new Imdb();



echo "<div class=\"CSSTableGenerator\" >";
echo "<table border> \n";
echo "<tr><td><b>Cartel</b></td><td><b>Title</b></td></tr> \n";
while ($row = mysql_fetch_row($run)){
	$movieArray = $imdb->getMovieInfoById($row[0],false) ;
?>
<td>
<img src="imdbImage.php?url=<?=$movieArray['poster']?>" />
</td>
<?php
echo "<td><a href=\"http://ratinghood.com/Film.php?ID=$row[0]\">$row[1]</a></td></tr> \n";
}
echo "</table> \n";
echo "  </div>";



 }
}


?>