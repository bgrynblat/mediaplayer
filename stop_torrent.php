<?php
	if(!isset($_GET['id']))
		exit();

	$id = $_GET['id'];
	echo exec("/usr/bin/transmission-remote -n 'transmission:transmission' -t $id -S");

?>
<br />
<a href=".">Back</a>
