<?php
	$_ENV["DL_FOLDER"] = "medias";
	$_ENV["TMP_FOLDER"] = "tmps";

	$_ENV["STORAGES"] = array("/");

	$_ENV["server"]["host"] = "home.bengr.net";
	$_ENV["server"]["ssh"]["user"] = "bgr";
	$_ENV["server"]["web"]["port"] = 80;
	$_ENV["server"]["web"]["protocol"] = "http";
	$_ENV["server"]["web"]["path"] = "mp";
	$_ENV["server"]["transmission"]["port"] = 9091;
	$_ENV["server"]["transmission"]["user"] = "transmission";
	$_ENV["server"]["transmission"]["pass"] = "transmission";

	$_ENV["VPN"]["present"] = true;
	$_ENV["VPN"]["type"] = "pptp";	#Can be : pptp / openvpn
	$_ENV["VPN"]["force"] = true;

	//storage management
	$file = "tmps/storages.cfg";
	if(file_exists($file)) {
		$handle = fopen($file, "r");
		if ($handle) {
    			while (($line = fgets($handle)) !== false) {
				array_push($_ENV["STORAGES"], trim($line));
				//echo "$line";
			}

			fclose($handle);
		}
	}
?>
