<?php

include('functions.php');

$target_dir = "torrents/";
$filename = removeSpecialChars(basename($_FILES["file_to_upload"]["name"]));
$target_file = $target_dir . $filename;
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

if(isset($_POST["submit"])) {
	echo $_FILES["file_to_upload"]["type"]."<br/>";
	echo $_FILES["file_to_upload"]["tmp_name"]."<br/>";
	echo $_FILES["file_to_upload"]["error"]."<br/>";

	if(move_uploaded_file($_FILES["file_to_upload"]['tmp_name'], $target_file)) {
		$transmission = getTransmissionRemoteCmd("-a $target_file 2>&1");
		echo exec($transmission);
	}
}
?>
<br />
<a href=".">Back</a>
