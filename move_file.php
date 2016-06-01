<?php

	include('functions.php');

	$file = $_GET["file"];
	$to = $_GET["dest"];
	$path = $_ENV["server"]["ssh"]["path"]."/".$file;

	$cmd = "sudo cp $path $to";
	echo $cmd;

	executeCommand("sudo cp \"$path\" \"$to\""," > /dev/null 2>/dev/null &");

?>
