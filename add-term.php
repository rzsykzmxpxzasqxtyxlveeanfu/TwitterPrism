<?

if($_SERVER['REQUEST_METHOD'] == "POST"){

	include ('functions.php');

	$termID = addTerm($_POST['term'],$_POST['description']);

	mysqli_close($link);

	if(is_numeric($termID)){

		header("Location: index.php?termID=". $termID);

	}

	exit();

}else{

?>
<html>
<body>
<form id="submit-term" method="POST" action="<? echo $_SERVER['PHP_SELF']; ?>">
New term: <input type="text" name="term"><br>
Short description: <input type="text" name="description"><br>
<input type="submit" value="add">
</form>
</body>
<html>
<?

}

?>
