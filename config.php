<?php

	function getConfValue($key) {
		$file = $_ENV["config"];
		$val = exec("cat $file | grep $key | grep -v \#");
		$arr = split("=", $val, 2);
		return $arr[1];
	}

	$cfg = "config.default";
	if(file_exists("config.cfg"))
		$cfg = "config.cfg";
	$_ENV["config"] = $cfg;

	$_ENV["DL_FOLDER"] = getConfValue("DL_FOLDER");
	$_ENV["TMP_FOLDER"] = getConfValue("TMP_FOLDER");
	$_ENV["STORAGES"] = array("/");

	$_ENV["server"]["host"] = getConfValue("server.host");
	$_ENV["server"]["ssh"]["user"] = getConfValue("server.ssh.user");
	$_ENV["server"]["ssh"]["path"] = getConfValue("server.ssh.path");
	$_ENV["server"]["web"]["port"] = getConfValue("server.web.port");
	$_ENV["server"]["web"]["protocol"] = getConfValue("server.web.protocol");
	$_ENV["server"]["web"]["path"] = getConfValue("server.web.path");
	$_ENV["server"]["transmission"]["port"] = getConfValue("server.transmission.port");
	$_ENV["server"]["transmission"]["user"] = getConfValue("server.transmission.user");
	$_ENV["server"]["transmission"]["pass"] = getConfValue("server.transmission.pass");

	$_ENV["VPN"]["present"] = getConfValue("VPN.present");
	$_ENV["VPN"]["type"] = getConfValue("VPN.type");	#Can be : pptp / openvpn

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
