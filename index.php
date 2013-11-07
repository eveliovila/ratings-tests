<!DOCTYPE html>
<html>



<head>

<title>Ratinghood</title>
<link href="Site.css" rel="stylesheet">


</head>

<body>
<?php include("Header.php"); ?>
<div id="main">

<form action='index.php' method='GET'>

<h1>Films</h1>
<input type='text' size='90' name='search'></br></br>
<input type='submit' name='submit' value='Search' ></br></br></br>

</form>

<?php include("search.php"); ?>
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