<html>
<body>
<?

include ('functions.php');

$stats[0]['descr'] = "Terms";
$stats[0]['query'] = "SELECT COUNT(*) AS c FROM terms";

$stats[1]['descr'] = "Found tweets";
$stats[1]['query'] = "SELECT COUNT(*) AS c FROM tweets";

$stats[2]['descr'] = "Our replies";
$stats[2]['query'] = "SELECT COUNT(*) AS c FROM tweets WHERE replyID != ''";

$stats[3]['descr'] = "Votes";
$stats[3]['query'] = "SELECT SUM(votes_pro + votes_con) AS c FROM terms";

$stats[4]['descr'] = "Unsearched";
$stats[4]['query'] = "SELECT COUNT(*) AS c FROM terms WHERE searched = '0000-00-00 00:00:00'";

echo "<div>\n";
echo "<h3>Totals</h3>\n";

echo "<table>\n";
echo "<tr><th>Total number of</th><th>#</th></tr>\n";

foreach($stats as $stat){

	if ($result = mysqli_query($link, $stat['query'])) {

		while ($row = mysqli_fetch_assoc($result)) {
			printf ("<tr>
					<td>". $stat['descr'] ."</td>
					<td style=\"text-align: right;\">%d</td>
				</tr>\n",
				$row['c']);
		}

	}

}

echo "</table>\n";
echo "</div>\n";

$lists[0]['title'] = "New terms";
$lists[0]['descr'] = "Last submitted terms.";
$lists[0]['order'] = "t.submitted DESC";

$lists[1]['title'] = "Last searches";
$lists[1]['descr'] = "Terms which were recently searched for at twitter.";
$lists[1]['order'] = "t.searched DESC";

$lists[2]['title'] = "Terms with most votes for";
$lists[2]['descr'] = "Terms with most votes for";
$lists[2]['order'] = "t.votes_pro DESC";

$lists[3]['title'] = "Terms with most votes against";
$lists[3]['descr'] = "Terms with most votes against";
$lists[3]['order'] = "t.votes_con DESC";

$lists[4]['title'] = "Terms with most votes total";
$lists[4]['descr'] = "Terms with most votes total";
$lists[4]['order'] = "(t.votes_pro + t.votes_con) DESC";

$lists[5]['title'] = "Terms most mentioned in tweets";
$lists[5]['descr'] = "Terms most mentioned in tweets";
$lists[5]['order'] = "tweets DESC";

$q	= "SELECT t.termID,t.term,t.submitted,t.searched,t.votes_pro,t.votes_con,(t.votes_pro + t.votes_con) AS votes_sum,COUNT(tw.tweetID) AS tweets FROM terms AS t LEFT OUTER JOIN tweets AS tw ON t.termID = tw.termID GROUP BY t.termID ORDER BY ";

foreach($lists as $list){

	$query = $q . $list[order] ." LIMIT 0,10";

	if ($result = mysqli_query($link, $query)) {
		
		echo "<div>\n";
		echo "<h3>". $list['title'] ."</h3>\n";
		echo "<p>". $list['descr'] ."</p>\n";
		echo "<table>\n";
		echo "<tr><th>Vote!</th><th>Term</th><th>Votes for</th><th>Votes against</th><th>Total votes</th><th>Tweets</th></tr>\n";

		while ($row = mysqli_fetch_assoc($result)) {
			printf ("<tr>
					<td class=\"booth-%d\">
						<a href=\"javascript:void(0);\" onclick=\"vote(%d,'pro');\" class=\"vote\">&uarr;</a>
						<a href=\"javascript:void(0);\" onclick=\"vote(%d,'con');\" class=\"vote\">&darr;</a>
					</td>
					<td><a href=\"javascript:void(0);\" onclick=\"term(%d);\">%s</a></td>
					<td>%d</td>
					<td>%d</td>
					<td>%d</td>
					<td><a href=\"javascript:void(0)\" onclick=\"show_tweets(%d)\">%d</a></td>
				</tr>\n",
				$row["termID"],$row["termID"],$row["termID"],$row["termID"], $row["term"], $row["votes_pro"], $row["votes_con"], $row["votes_sum"],$row["termID"],$row["tweets"]);
		}

		echo "</table>\n";
		echo "</div>\n";

		mysqli_free_result($result);

	}

}

mysqli_close($link);

?>
</body>
<html>
