<?php
	include('config.php');

	function getFiles() {
		$files = scandir($_ENV['DL_FOLDER']);
		$files = array_splice($files, 2, count($files));

		//echo $files;
		//array_push("BLABLABLA", $files);
		return $files;
	}

?>
