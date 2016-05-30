<?php
	$_ENV["DL_FOLDER"] = "medias";
	$_ENV["TMP_FOLDER"] = "tmps";

	$_ENV["STORAGES"] = array("/");

	$_ENV["transmission"]["host"] = "localhost";
	$_ENV["transmission"]["port"] = "9091";
	$_ENV["transmission"]["user"] = "transmission";
	$_ENV["transmission"]["pass"] = "transmission";

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
