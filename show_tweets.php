<?

if(!isset($_GET['termID']) || !is_numeric($_GET['termID'])){

	header("Location: ./");
	exit();

}

include ('functions.php');

?>
<html>
<body>
<?

$termID = mysqli_real_escape_string($link, $_GET['termID']);

$query = "SELECT tweetID,text FROM tweets WHERE termID = ". $termID;

	if($result = mysqli_query($link, $query)) {

		echo "<ul>\n";

		while ($row = mysqli_fetch_assoc($result)) {

			printf("<li>%s</li>\n",twitterify($row['text']));

		}

		echo "</ul>\n";

	}

?>
</body>
<html>
