<?

if($_SERVER['REQUEST_METHOD'] == "POST"){

	if(isset($_POST['termID']) && isset($_POST['vote']) && is_numeric($_POST['termID']) && ($_POST['vote'] == "pro" || $_POST['vote'] == "con")){

		include ('functions.php');

		$termID = mysqli_real_escape_string($link, $_POST['termID']);
		$type	= mysqli_real_escape_string($link, $_POST['vote']);

		$query = "UPDATE terms SET votes_". $type ." = votes_". $type ." + 1 WHERE termID = ". $termID;

		if(mysqli_query($link, $query)) {
			echo "succes";
		}else{
			echo "error";
		}

	}

	mysqli_close($link);

}

?>
