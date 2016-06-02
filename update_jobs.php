<?php

include('functions.php');

$tmp_folder = $_ENV["TMP_FOLDER"];
$filename = "jobs.last";
$tmp_filename = "jobs.tmp";

$file = "$tmp_folder/$filename";
$tmp = "$tmp_folder/$tmp_filename";

$now = time();
	//echo "Lets do it";
	$files = checkJobs();
	$out = "{\"updated\":\"".($now+1000)."\",\"jobs\":[";

	//{url, full_path, filename}
	for($i = 0; $i<count($files); $i++) {
		
		$f = $files[$i];
		$f = trim($f, ";");

		$out = $out."{\"job\":\"$f\"}";
		if($i < count($files)-1)	$out = $out.",";
	}
	
	$out = $out."]}";


header('Content-Type: application/json');
//readfile($file);
echo $out;
?>
