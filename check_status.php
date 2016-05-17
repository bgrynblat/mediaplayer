<?php
	include('functions.php');

	$out = '{"storages":[';

	$split = checkStatus();

	foreach($split as $line) {
		$out = $out."{\"mnt\":\"$line\",\"mounted\":";

		$mounted = false;
		foreach($_ENV["STORAGES"] as $mnt) {
			if(strpos($line, $mnt." ") !== false) 
				$mounted = "true";
		}
		
		$out = $out.($mounted ? "true" : "false")."},";
	}


	$out = rtrim($out, ",");
	$out = $out.'],"vpn":';

	$val = exec("ifconfig tun0; echo $?;");
	$out = $out.($val == "1" ? "false" : "true");

	$out = $out.'}';

	header('Content-Type: application/json');

	echo $out;
?>
