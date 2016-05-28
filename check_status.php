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
	$out = $out.'],"vpn":{"status":';

	$val = checkVPNStatus();
	$out = $out.($val ? "true" : "false");

	$out = $out.', "present": "'.$_ENV["VPN"]["present"].'"';
	$out = $out.', "force": "'.$_ENV["VPN"]["force"].'"';
	$out = $out.', "type": "'.$_ENV["VPN"]["type"].'"}}';

	header('Content-Type: application/json');

	echo $out;
?>
