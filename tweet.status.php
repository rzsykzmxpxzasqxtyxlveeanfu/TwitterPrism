<?php

// get all type 2 messages (type 1 are replies)
$query = "SELECT messageID,message FROM messages WHERE type = 2";

if($result = mysqli_query($link, $query)) {

	$i = 0;
		
	while ($row = mysqli_fetch_assoc($result)) {

		$message[$i]['id'] = $row['messageID'];
		$message[$i]['msg'] = $row['message'];

		$i++;

	}

}

// get min/max IDs for messages
$rand['min'] = 0;
$rand['max'] = count($message) - 1;

$query = "SELECT termID,term FROM terms ORDER BY RAND() LIMIT 0,1";

// set counter
$postedtweets = 0;

if($result = mysqli_query($link, $query)) {
		
	while ($row = mysqli_fetch_assoc($result)) {

		$r = rand($rand['min'],$rand['max']);
		$tweet = str_replace('%term%',$row['term'],$message[$r]['msg']);

		// add term as hashtag
		$tweet .= " #". preg_replace('/\s/', '',$row['term']);

		// https://dev.twitter.com/docs/api/1/post/statuses/update
		$params = array(
			'status' => $tweet
		);
		$reply = $cb->statuses_update($params);

		$postedtweets++;

	}

}

echo date("d-m-y H:i:s") ." Posted $postedtweets tweets.";

?>
