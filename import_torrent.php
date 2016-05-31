<?php

	include('functions.php');

	$url = $_GET["torrent"];
	$path =  exec("scripts/import_torrent.sh '$url'");

	echo $path."<br/>";
	$transmission = getTransmissionRemoteCmd("-a $path 2>&1");
	echo exec($transmission);
?>
<br/>
<a href=".">Back</a>
