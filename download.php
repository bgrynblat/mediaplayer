<?php
	include('config.php');
	
	//$furl = $_ENV["DL_FOLDER"]."/".$_GET['file'];
	$furl = $_GET['file'];

	$srv = $_SERVER["HTTP_HOST"];
        $req = $_SERVER['REQUEST_URI'];

	$req = substr($req, 0, strpos($req, "?"));
	$rev = strrev($req);
	$pos = strpos($rev, "/");
	$tmp = substr($rev, $pos);
	$req = strrev($tmp);

	$url =  "http://$srv$req$furl";

	//echo strrev($str);
        //echo substr($str, 0, strrchr($str, "/"));
	//echo strpos($str, "/");
	
	//echo $url;

	header("Location: $url");
?>
