<?php
	$url = $_GET["torrent"];
	echo exec("scripts/import_torrent.sh '$url'");
?>
<br/>
<a href=".">Back</a>
