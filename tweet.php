<?php

header('Content-Type: text/html; charset=utf-8');

require_once ('functions.php');

require_once ('codebird/codebird.php');
\Codebird\Codebird::setConsumerKey('foo', 'bar');

$cb = \Codebird\Codebird::getInstance();

$cb->setToken('foo', 'bar');

// select a random file to include: reply, retweet, post a status of favorite a tweet
$include[] = "reply";
// $include[] = "retweet"; // Can't find HTTP method to use for 'statuses/retweet'
$include[] = "status";
// $include[] = "favorite"; // error 32

if(isset($_GET['i']) && is_numeric($_GET['i'])){
	$i = preg_replace('/[^a-zA-Z0-9]*/','',$_GET['i']);
}else{
	$i = rand(0,count($include) - 1);
}

include("tweet.". $include[$i] .".php");

mysqli_free_result($result);
mysqli_query($link, $query);

?>
