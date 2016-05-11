<?php
	include('functions.php');

	$out = '{"storages":[';

	$split = checkStatus();

	foreach($split as $line)
		$out = $out."\"$line\",";

	$out = rtrim($out, ",");
	$out = $out.']}';

	header('Content-Type: application/json');

	echo $out;
?>
