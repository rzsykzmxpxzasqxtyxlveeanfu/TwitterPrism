<?

include ('functions.php');

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>NSA terms</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="functions.js"></script>
	<link href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
	<style type="text/css">
		body{
			background-color: #E7E7E7;
		}
		a{
			text-decoration: none;
		}
		.box{
			background-color: #FFFFFF;
			border: 1px solid #A7A7A7;
			padding: 5px;
			margin: 5px;
		}
	</style>
</head>
<body>
<h1>NSA terms</h1>
<p>This website searches twitter for tweets with terms NSA is monitoring.</p>
<div class="box">
	<h2>Search</h2>
	<p>Find terms or descriptions containing <input id="find" type="text">
	or <a href="export.php">download all terms and their descriptions in csv format</a>.</p>
</div>
<div class="box">
	<h2>Add term</h2>
	<div id="add-term"></div>
</div>
<div class="box" id="term">
	<h2>Term meta data</h2>
	<div>Click on a term to see it's meta data.</div>
</div>
<div class="box">
	<h2>Tweets</h2>
	<div id="tweets">
		Click on a term's number of tweets to see all tweets we fetched.
	</div>
</div>
<div class="box">
	<h2>Statistics</h2>
	<div id="dashboard"></div>
</div>
</body>
</html>
