<?php
	include('functions.php');

	if($_ENV["server"]["host"] != "localhost" && $_ENV["server"]["host"] != "127.0.0.1") {
		HTTPRequest("tmps/storages.cfg", "tmps/storages.cfg");
		reloadStorages();
	}

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

	$f = executeCommand("ls tmps/forcevpn.yes | wc -l");
	$force = ($f == "0" ? "false" : "true");

	$out = $out.', "present": '.$_ENV["VPN"]["present"];
	$out = $out.', "force": '.$force;
	$out = $out.', "type": "'.$_ENV["VPN"]["type"].'"}}';

	header('Content-Type: application/json');

	echo $out;
?>
