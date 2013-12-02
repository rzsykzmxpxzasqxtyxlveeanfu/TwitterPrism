<?php

header('Content-Type: text/html; charset=utf-8');

require_once ('functions.php');

if(isset($_GET['termID']) && is_numeric($_GET['termID'])){

	$termID = mysqli_real_escape_string($link, $_GET['termID']);
	$query = "SELECT termID,term FROM terms WHERE termID = ". $termID ." LIMIT 0,1";

}else{

	// select a term with less than average number of tweets
	$query = "	SELECT";
	$query .= "		t.termID,";
	$query .= "		t.term,";
	$query .= "		COUNT(tw.termID) AS num_tweets";
	$query .= "	FROM";
	$query .= "		terms AS t";
	$query .= "	INNER JOIN";
	$query .= "		tweets AS tw";
	$query .= "	ON";
	$query .= "		t.termID = tw.termID";
	$query .= "	GROUP BY";
	$query .= "		tw.termID";
	$query .= "	HAVING";
	$query .= "		COUNT(tw.termID)";
	$query .= "		<";
	$query .= "		(SELECT";
	$query .= "			AVG(c.num) AS a";
	$query .= "		FROM";
	$query .= "			(SELECT";
	$query .= "				COUNT(tweetID) AS num";
	$query .= "			FROM";
	$query .= "				tweets";
	$query .= "			GROUP BY";
	$query .= "				termID) AS c)";
	$query .= "	ORDER BY RAND()";
	$query .= "	LIMIT 0,1";

}

if($result = mysqli_query($link, $query)) {
		
	while ($row = mysqli_fetch_assoc($result)) {

		$termID = $row["termID"];
		$q = $row["term"];

	}


}

require_once ('codebird/codebird.php');
\Codebird\Codebird::setConsumerKey('foo', 'bar');

$cb = \Codebird\Codebird::getInstance();

$params = array(
	'lang' => 'en',
	'result_type ' => 'recent',
	'q' => $q
);

$tweets = $cb->search_tweets($params, true);

$savedtweets = 0;

foreach($tweets->statuses as $tweet){

	if(!saveTweet($termID,$tweet->id,$tweet->user->id,$tweet->text)){
		echo "failed to save tweetID ". $tweetID ." from userID ". $userID .": '". $text ."'<br>\n";
	}else{
		$savedtweets++;
	}

}

$query = "UPDATE terms SET searched = NOW() WHERE termID = ". $termID;
mysqli_query($link, $query);

// echo date("d-m-y H:i:s") ." Saved $savedtweets tweets for term '$q' with id $termID.";
header("Location: ./");

?>
