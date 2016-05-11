<?php
	
	if(!isset($_GET['file']))
		exit();

	$file = $_GET['file'];

	echo exec("rm -rvf \"$file\" 2>&1");

?>
