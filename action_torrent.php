<?php

	if(!isset($_GET['id']) || !isset($_GET["action"]))
		exit();

	include("functions.php");

	$id = $_GET['id'];
	$action = $_GET['action'];

	$transmission = getTransmissionRemoteCmd("");

	if($action == "start")	echo exec("$transmission -t $id -s");
	else if($action == "stop")  echo exec("$transmission -t $id -S");
	else if($action == "remove")  echo exec("$transmission -t $id -r");

?>
<br />
<a href=".">Back</a>
