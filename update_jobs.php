<?php

include('functions.php');

$tmp_folder = $_ENV["TMP_FOLDER"];
$filename = "jobs.last";
$tmp_filename = "jobs.tmp";

$file = "$tmp_folder/$filename";
$tmp = "$tmp_folder/$tmp_filename";

$checks = 0;
while(file_exists($tmp) && $checks <= 10) {
	$checks++;
	if($checks >= 10) {
		echo "Timeout !";
		exit();
	}
}

$now = time();
	//echo "Lets do it";
	$files = checkJobs();

	$handle = fopen($tmp, "w");
	fwrite($handle, "{\"updated\":\"".($now+1000)."\",\"jobs\":[");

	//{url, full_path, filename}
	for($i = 1; $i<count($files); $i++) {
		$f = $files[$i];

		fwrite($handle, "{\"job\":\"$f\"}");
		if($i < count($files)-1)	fwrite($handle, ",");
	}
	
	fwrite($handle, "]}");
	fclose($handle);

	rename($tmp, $file);

header('Content-Type: application/json');
readfile($file);
?>
