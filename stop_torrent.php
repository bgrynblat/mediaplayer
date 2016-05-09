<?php
	if(!isset($_GET['id']))
		exit();

	exec("scripts/pause_torrent.sh $_GET['id']");

?>
