<?php
	include('functions.php');
	
	//$furl = $_ENV["DL_FOLDER"]."/".$_GET['file'];
	$furl = $_GET['file'];
	$url = "";
	$srv = $_SERVER["HTTP_HOST"];
        $req = $_SERVER['REQUEST_URI'];
	$ip = $_SERVER['REMOTE_ADDR'];

	if($_ENV["server"]["host"] != "localhost" && $_ENV["server"]["host"] != "127.0.0.1") {
		executeCommand("sudo ip route add $ip via 192.168.1.1 dev eth0");
		$url = getUrl($furl);
	} else {
		$req = substr($req, 0, strpos($req, "?"));
		$rev = strrev($req);
		$pos = strpos($rev, "/");
		$tmp = substr($rev, $pos);
		$req = strrev($tmp);

		$url =  "http://$srv$req$furl";

		//echo strrev($str);
        	//echo substr($str, 0, strrchr($str, "/"));
		//echo strpos($str, "/");
	
	}

	//echo $url."<br/>".$ip;
	header("Location: $url");
?>
