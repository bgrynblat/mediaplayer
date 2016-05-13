<?php

$target_dir = "torrents/";
$target_file = $target_dir . basename($_FILES["file_to_upload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

if(isset($_POST["submit"])) {
	echo $_FILES["file_to_upload"]["type"]."<br/>";
	echo $_FILES["file_to_upload"]["tmp_name"]."<br/>";
	echo $_FILES["file_to_upload"]["error"]."<br/>";

	if(move_uploaded_file($_FILES["file_to_upload"]['tmp_name'], $target_file)) 
		echo exec("/usr/bin/transmission-remote -n 'transmission:transmission' -a $target_file");
}
?>
<br />
<a href=".">Back</a>
