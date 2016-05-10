<?php

include('functions.php');

$tmp_folder = $_ENV["TMP_FOLDER"];
$filename = "files.last";
$tmp_filename = "files.tmp";

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

$update=false;
if(file_exists($file)) {
	$filetime = filemtime($file);

	//echo "$file was last modified: ".$filetime;
	//echo "<br/>";
	//echo "Now: ".time();
	
	if($now > $filetime+60) {
		unlink($file);
		$update = true;
	}
} else $update = true;

if($update) {
	//echo "Lets do it";
	$files = getFiles();

	$handle = fopen($tmp, "w");
	fwrite($handle, "{\"updated\":\"".($now+1000)."\",\"files\":[");

	//{url, full_path, filename}
	for($i = 0; $i<count($files); $i++) {
		$f = $files[$i];
	
		fwrite($handle, "{\"url\":\"$f[0]\",");
		fwrite($handle, "\"path\":\"$f[1]\",");
		fwrite($handle, "\"filename\":\"$f[2]\"}");
		
		if($i < count($files)-1)	fwrite($handle, ",");
	}
	
	fwrite($handle, "]}");
	fclose($handle);

	rename($tmp, $file);
}

header('Content-Type: application/json');
readfile($file);
?>
