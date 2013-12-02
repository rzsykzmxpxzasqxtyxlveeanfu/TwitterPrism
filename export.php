<?

include ('functions.php');

$filename = "terms-". date("Ymd-His") .".csv";

$query = "SELECT term,description FROM terms ORDER BY term";

$output = "'term','description'\n";
 
// Gets the data from the database
if($result = mysqli_query($link, $query)) {

	while ($row = mysqli_fetch_assoc($result)) {

		$output .= "'". $row['term'] ."','". $row['description'] ."'\n";
			
	}

}

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Length: " . strlen($output));

header("Content-type: text/x-csv");
//header("Content-type: text/csv");
//header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$filename");
echo $output;
exit;

?>
