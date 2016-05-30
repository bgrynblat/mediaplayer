<?php

	if(!isset($_GET['id']) || !isset($_GET["action"]))
		exit();

	include("config.php");

	$id = $_GET['id'];
	$action = $_GET['action'];


	$transmission = "/usr/bin/transmission-remote ".$_ENV["transmission"]["host"].":".$_ENV["transmission"]["port"]." -n '".$_ENV["transmission"]["user"].":".$_ENV["transmission"]["pass"]."'";

	if($action == "start")	echo exec("$transmission -t $id -s");
	else if($action == "stop")  echo exec("$transmission -t $id -S");
	else if($action == "remove")  echo exec("$transmission -t $id -r");

?>
<br />
<a href=".">Back</a>
