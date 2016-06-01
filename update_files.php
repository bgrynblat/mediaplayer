<?php

include('functions.php');

$tmp_folder = $_ENV["TMP_FOLDER"];
$filename = "files.last";
$tmp_filename = "files.tmp";
       
$file = "$tmp_folder/$filename";
$tmp = "$tmp_folder/$tmp_filename";

$force = false;
if(isset($_GET['force']))
	$force = true;

if($_ENV["server"]["host"] != "localhost" && $_ENV["server"]["host"] != "127.0.0.1") {
	if($force) {
		executeCommand("cd ".$_ENV["server"]["ssh"]["path"]." ; sudo chmod 777 ".$file." ; scripts/update_files.sh > ".$file);
	}
        HTTPRequest($file, $file);
	
} else {
	executeCommand("scripts/update_files.sh > ".$file);
}

header('Content-Type: application/json');
readfile($file);
?>
