<html>
<body>
<?

if($_SERVER['REQUEST_METHOD'] == "POST"){

	include ('functions.php');

	$terms = explode("\n",$_POST['terms']);

	foreach($terms as $term){

		$parts = explode(",",$term);

		if(strlen($parts[0]) > 1){

			$termID[] = addTerm(addslashes($parts[0]),addslashes($parts[1]));

		}

	}

	echo "added ". count($termID) ." terms\n";

}else{

?>
<form id="submit-term-batch" method="POST" action="<? echo $_SERVER['PHP_SELF']; ?>">
New terms<br/>
Format:
<pre>
	<code>
'term 1','description 1'
'term 2',
'term 3',
'term 4','description 4'
'term n','description n'
	</code>
</pre>
<textarea name="terms" cols="70" rows="15"></textarea>
<input type="submit" value="add">
</form>
<?

}

?>
</body>
</html>
