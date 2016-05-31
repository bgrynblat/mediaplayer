<?php

	include('functions.php');

	$file = $_GET["file"];
	$to = $_GET["dest"];

	executeCommand("sudo cp mediaplayer/$file $to & ; disown");

?>
