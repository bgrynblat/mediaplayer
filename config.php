<?php
	function getConfValue($key, $file) {
		$val = exec("cat $file | grep $key | grep -v \#");
		$arr = split("=", $val, 2);
		return $arr[1];
	}

	$cfg = "config.default";
	if(file_exists("config.cfg"))
		$file = "config.cfg";

	$_ENV["DL_FOLDER"] = getConfValue("DL_FOLDER", $file);
	$_ENV["TMP_FOLDER"] = getConfValue("TMP_FOLDER", $file);
	$_ENV["STORAGES"] = array("/");

	$_ENV["server"]["host"] = getConfValue("server.host", $file);
	$_ENV["server"]["ssh"]["user"] = getConfValue("server.ssh.user", $file);
	$_ENV["server"]["web"]["port"] = getConfValue("server.web.port", $file);
	$_ENV["server"]["web"]["protocol"] = getConfValue("server.web.protocol", $file);
	$_ENV["server"]["web"]["path"] = getConfValue("server.web.path", $file);
	$_ENV["server"]["transmission"]["port"] = getConfValue("server.transmission.port", $file);
	$_ENV["server"]["transmission"]["user"] = getConfValue("server.transmission.user", $file);
	$_ENV["server"]["transmission"]["pass"] = getConfValue("server.transmission.pass", $file);

	$_ENV["VPN"]["present"] = getConfValue("VPN.present", $file);
	$_ENV["VPN"]["type"] = getConfValue("VPN.type", $file);	#Can be : pptp / openvpn
	$_ENV["VPN"]["force"] = getConfValue("VPN.force", $file);

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
