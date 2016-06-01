<?php
	include_once('config.php');

	function removeSpecialChars($str) {
		$array = array("[", "]", "{", "}", " ", "%", "$", "/", "<", ">", "|", "#", "&", "!", "(", ")", ",", ":", ";", "?");
		foreach($array as $c) 
			$str = str_replace($c, ".", $str);

		return $str;
	}

	function getFilesRecursively($folder, $origin) {
		$files = scandir($folder);
                $files = array_splice($files, 2, count($files));

		$array = array();

		foreach($files as $f) {
			//$file = {url, full_path, filename}

			if(is_link("$folder/$f")) {
				$link=readlink("$folder/$f");
				$arr = getFilesRecursively("$link", "$origin/$f");
                                foreach($arr as $a) {
					$file = array();

					array_push($file, "$a[0]");
					array_push($file, "$a[1]");
					array_push($file, "$a[2]");

					array_push($array, $file);
				}
			} else if(is_dir("$folder/$f")) {
				$arr = getFilesRecursively("$folder/$f", "$origin/$f");
				foreach($arr as $a) {
					$file = array();
                                        array_push($file, "$a[0]");
                                        array_push($file, "$a[1]");
                                        array_push($file, "$a[2]");

                                        array_push($array, $file);
				}
			} else {
				$file = array();
				array_push($file, "$origin/$f");
				array_push($file, "$folder/$f");
				array_push($file, "$f");

				array_push($array, $file);
			}
		}

		return $array;
	}

	function getTransmissionRemoteCmd($action) {
		$transmission = "/usr/bin/transmission-remote ".$_ENV["server"]["host"].":".$_ENV["server"]["transmission"]["port"]." -n '".$_ENV["server"]["transmission"]["user"].":".$_ENV["server"]["transmission"]["pass"]."'";
		$transmission = $transmission." ".$action;

		return $transmission;
	}

	function reloadStorages() {
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
	}

	function getUrl($file) {
		$prot = $_ENV["server"]["web"]["protocol"];
                $host = $_ENV["server"]["host"];
                $path = $_ENV["server"]["web"]["path"];

		$url = "$prot://$host/$path/$file";

		return $url;
	}

	function HTTPRequest($file, $out) {
		$prot = $_ENV["server"]["web"]["protocol"];
        	$host = $_ENV["server"]["host"];
		$path = $_ENV["server"]["web"]["path"];

		$url = getUrl($file);
		$req = "curl $url > $out";

		exec("echo $req >> tmps/cmds.log");
		exec($req);
	}

	function executeCommand($cmd, $extraparams = "") {

		$host = $_ENV["server"]["host"];
                $fcmd = "";

                if($host == "localhost" || $host == "127.0.0.1")
                        $fcmd = $cmd;
                else {
                        $user = $_ENV["server"]["ssh"]["user"];
                        $cmd = str_replace("\"", "\\\"", $cmd);
                        $fcmd = "ssh $user@$host \"".$cmd."\" $extraparams";
                }
                exec("echo 'COMMAND = $fcmd' >> tmps/cmds.log");
                $out = exec($fcmd);
                exec("echo 'OUT = $out' >> tmps/cmds.log");
                return $out;
	}

	function getFiles() {
		//$files = scandir($_ENV['DL_FOLDER']);
		$files = getFilesRecursively($_ENV['DL_FOLDER'], $_ENV['DL_FOLDER']);

		$array = array();
		foreach($files as $file) {
			$f = strrev($file[0]);
			if(strpos($f, "trap.") === false)	array_push($array, $file);
		}

		return $array;
	}

	function checkJobs() {
		//$out = exec("scripts/check_jobs.sh");

		//PREFIX="tmps"
		$tr = getTransmissionRemoteCmd("-l");

		$cmd = "$tr | tr \"\n\" \"|\" | sed -e's/  /;/g' | sed -e 's/;;*/;/g' |  sed -e's/; */;/g' | sed -e's/|;*/|/g'";
		$out = exec($cmd);

		$array = explode("|", $out);

		array_pop($array);
		array_pop($array);

		return $array;
	}

	function checkStatus() {
		$str = executeCommand("df --output=target,pcent,source | sed -e's/  */ /g' | tr \"\\n\" \"|\" 2>&1");

		$array = array();

        	$split = explode("|", $str);
        	foreach($split as $line) {
        	        if(strpos($line, "/") !== false) {
				array_push($array, $line);
			}
        	}

		return $array;
	}

	function getMounts() {
		$array = checkStatus();
	}

	function checkVPNStatus() {
		$out = false;

		if($_ENV["VPN"]["present"]) {
			$dev = "";

			if($_ENV["VPN"]["type"] == "pptp")
				$dev = "ppp0";
			else if($_ENV["VPN"]["type"] == "openvpn")
				$dev = "tun0";

			//$val = exec("ifconfig $dev ; echo $?;");
			$val = executeCommand("/sbin/ifconfig $dev | wc -l");
        		$out = ($val == "0" ? false : true);
		}

		return $out;
	}

?>
