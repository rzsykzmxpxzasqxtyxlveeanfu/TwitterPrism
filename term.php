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

$query = "SELECT t.termID,t.term,t.description,t.submitted,t.searched,t.votes_pro,t.votes_con,COUNT(tw.tweetID) AS tweets FROM terms AS t LEFT OUTER JOIN tweets AS tw ON t.termID = tw.termID WHERE t.termID = ". $termID ." GROUP BY t.termID";

	if($result = mysqli_query($link, $query)) {
		
		while ($row = mysqli_fetch_assoc($result)) {

			printf("<h2>Term '%s'</h2>\n",$row['term']);

			echo "<h3>Properties</h3>\n";

			echo "<table>\n";

      // replace urls with links
			$description = preg_replace('!(\s|^)((https?://|www\.)+[a-z0-9_./?=&-]+)!i', ' <a href="$2" target="_blank">$2</a>',$row['description']);

			printf("<tr><td>Description</td><td>%s</td></tr>\n",stripslashes($description));
			printf("<tr><td>Number of tweets</td><td><a href=\"javascript:void(0);\" onclick=\"show_tweets(%d)\">%d</a></td></tr>\n",$row['termID'],$row['tweets']);
			printf("<tr><td>Votes for</td><td>%d</td></tr>\n",$row['votes_pro']);
			printf("<tr><td>Votes against</td><td>%d</td></tr>\n",$row['votes_against']);
			printf("<tr><td>Last search on twitter</td><td>%s</td></tr>\n",$row['searched']);
			printf("<tr><td>Submitted</td><td>%s</td></tr>\n",$row['submitted']);

			echo "</table>\n";

			echo "<h3>Actions</h3>\n";
			echo "<ul>\n";
			printf("<li><a href=\"search-tweets.php?termID=%d\">Search</a></li>\n",$row['termID']);
			printf("<li><a href=\"tweet.php?i=0&termID=%d\">Reply</a></li>\n",$row['termID']);
			echo "</ul>\n";

			echo "<h3>Vote</h3>\n";
			echo "<p>Do you think this term is mostly used by individuals with bad intentions?</p>\n";

			printf("<span class=\"booth-%d\">", $row["termID"]);
			printf("<a href=\"javascript:void(0);\" onclick=\"vote(%d,'pro');\" class=\"vote\">Yes</a>", $row["termID"]);
			echo " or ";
			printf("<a href=\"javascript:void(0);\" onclick=\"vote(%d,'con');\" class=\"vote\">No</a>", $row["termID"]);
			echo "</span>\n";

		}

	}

?>
</body>
<html>
