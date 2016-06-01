<?php

	include('functions.php');
	
	if(!isset($_GET['file']))
		exit();

	$file = $_GET['file'];

	executeCommand("sudo rm -rvf \"".$_ENV["server"]["ssh"]["path"]."/$file\" 2>&1");

?>
