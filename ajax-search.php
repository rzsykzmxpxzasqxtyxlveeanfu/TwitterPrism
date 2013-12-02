<?

if(isset($_GET['term']) && strlen($_GET['term']) > 0){

	include ('functions.php');

	$q = mysqli_real_escape_string($link, $_GET['term']);

//	$query = "SELECT t.termID,t.term FROM terms AS t LEFT OUTER JOIN tweets AS tw ON t.termID = tw.termID WHERE t.term LIKE '%". $q ."%' OR t.description LIKE '%". $q ."%' GROUP BY tw.termID ORDER BY COUNT(tw.tweetID) DESC LIMIT 0,20";
	$query = "SELECT termID,term FROM terms WHERE term LIKE '%". $q ."%' OR description LIKE '%". $q ."%' ORDER BY term ASC LIMIT 0,20";

	if ($result = mysqli_query($link, $query)) {

		$i = 0;

		while ($row = mysqli_fetch_assoc($result)) {

			$terms[$i]['value'] = $row['termID'];
			$terms[$i]['label'] = stripslashes($row['term']);

			$i++;

		}

		echo json_encode($terms);

	}

	mysqli_close($link);

}

?>
