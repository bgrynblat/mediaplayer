<?php

	include('config.php');

	if(!isset($_GET["mount"])) {
		http_response_code(400);
		exit();
	}

	$mnt = $_GET["mount"];
	$name = $_ENV["DL_FOLDER"]."/mount_".time();

	echo exec("ln -s ".$mnt." ".$name." 2>&1");
	echo exec("scripts/add_storage.sh $mnt 2>&1");
	
	echo "<a href='.'>Back</a>";
?>
