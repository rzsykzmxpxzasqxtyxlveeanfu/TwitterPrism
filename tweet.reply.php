<?php

// get all messages
$query = "SELECT messageID,message FROM messages WHERE type = 1";

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

// get all tweets without reply
//$query = "SELECT tw.tweetID,tw.termID,t.term,tw.statusID,tw.userID FROM tweets AS tw INNER JOIN terms AS t ON tw.termID = t.termID WHERE tw.replyID = 0 ORDER BY tw.tweetID ASC LIMIT 0,1";
$query = "SELECT tw.tweetID,tw.termID,t.term,tw.statusID,tw.userID FROM tweets AS tw INNER JOIN terms AS t ON tw.termID = t.termID WHERE tw.replyID = 0 ";

if(isset($_GET['termID']) && is_numeric($_GET['termID'])){

	$query .= " AND tw.termID = ". $_GET['termID'];

}

$query .= " ORDER BY RAND() LIMIT 0,5";

// set counter
$repliedtweets = 0;

if($result = mysqli_query($link, $query)) {
		
	while ($row = mysqli_fetch_assoc($result)) {

		// get the username via user_id
		// https://dev.twitter.com/docs/api/1.1/get/users/show
		// user_id to get screen_name
		$users = $cb->users_lookup('user_id='. $row['userID'], true);

		foreach($users as $user){

			$username = $user->screen_name;
			break;

		}

		// construct reply text
		$r = rand($rand['min'],$rand['max']);
		$tweet = "@". $username ." ";
		$tweet .= str_replace('%term%',$row['term'],$message[$r]['msg']);

		// reply
		// https://dev.twitter.com/docs/api/1/post/statuses/update
		// in_reply_to_status_id
		// @screen_name %message%
		$params = array(
			'in_reply_to_status_id' => $row['statusID'],
			'status' => $tweet
		);
		$reply = $cb->statuses_update($params);

		// get the ID of the status
		// update tweet.replyID
		$replyID = $reply->id;

		// update tweets.replyID
		$update = "UPDATE tweets SET replyID = ". $replyID ." WHERE tweetID = ". $row['tweetID'];
		if(!mysqli_query($link, $update)){
			echo "failed to update tweetID ". $tweetID ." with replyID ". $replyID ."<br>\n";
		}else{
			$repliedtweets++;
		}

	}

}

echo date("d-m-y H:i:s") ." Replied to $repliedtweets tweets.";

?>
