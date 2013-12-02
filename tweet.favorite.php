<?php

$query = "SELECT termID,term FROM terms WHERE searched = '0000-00-00 00:00:00' ORDER BY RAND() LIMIT 0,1";

if($result = mysqli_query($link, $query)) {
		
	while ($row = mysqli_fetch_assoc($result)) {

		$termID = $row["termID"];
		$q = $row["term"];

	}

}

$params = array(
	'lang' => 'en',
	'q' => $q,
	'result_type ' => 'recent',
	'rpp' => 2 // fetch only 2 tweets
);

$tweets = $cb->search_tweets($params, true);

print_r($tweets);
echo "\n\n";

$favorites = 0;

foreach($tweets->statuses as $tweet){

	echo $tweet->id;

	$favo = $cb->favorites_create($tweet->id);

print_r($favo);
break;

	$favorites++;

}

echo date("d-m-y H:i:s") ." Favorited $favorites tweets with term '$q'";

?>
