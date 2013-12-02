<?

$link = mysqli_connect("localhost", "database_user", "database_password", "database_name");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

function addTerm($term,$description = ""){

	$term		= trim($term);
	$description	= trim($description);

	if(strlen($term) > 0){

		$term		= mysqli_real_escape_string($GLOBALS['link'], $term);
		$description	= mysqli_real_escape_string($GLOBALS['link'], $description);

		$query = "SELECT termID FROM terms WHERE UPPER(term) = UPPER('$term ')";

		if($result = mysqli_query($GLOBALS['link'], $query)) {

			if($result->num_rows == 1){

				// term already exists, return termID
				return $result->termID;

			}else{

				// add new term, return termID
				$query = "INSERT INTO terms (term,description) VALUES ('$term','$description')";
	
				if(mysqli_query($GLOBALS['link'], $query)) {
					return mysqli_insert_id($GLOBALS['link']);
				}else{
					die("ERROR: Term '". $term ."' was not added.");
				}

			}

		}

	}else{
		die("ERROR: Term was empty.");
	}

}

function saveTweet($termID,$tweetID,$userID,$text){

	if(is_numeric($termID) && is_numeric($tweetID) && is_numeric($userID) && strlen($text) > 0){

		$text = mysqli_real_escape_string($GLOBALS['link'], $text);

		$query = "INSERT INTO tweets (termID,statusID,userID,text) VALUES ($termID,$tweetID,$userID,'$text')";

		// echo "<code>". $query ."</code><br>\n";

		if(mysqli_query($GLOBALS['link'], $query)) {
			return true;
		}else{
			return false;
		}

	}else{
		die("ERROR: termID, tweetID, userID or text were invalid.");
	}

}

function twitterify($ret) {
	// http://www.snipe.net/2009/09/php-twitter-clickable-links/
	$ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);
	$ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);
	$ret = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $ret);
	$ret = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $ret);
	return $ret;
}

?>
