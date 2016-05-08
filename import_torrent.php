<?php
	$url = $_GET["torrent"];
	exec("scripts/import_torrent.sh $url");
?>
