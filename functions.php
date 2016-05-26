<?php
	include('config.php');

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
		$out = exec("scripts/check_jobs.sh");
		$array = explode("|", $out);

		array_pop($array);
		array_pop($array);

		return $array;
	}

	function checkStatus() {
		$str = exec("df --output=target,pcent,source | sed -e's/  */ /g' | tr \"\\n\" \"|\"");

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

			$val = exec("ifconfig $dev ; echo $?;");
        		$out = ($val == "1" ? false : true);
		}

		return $out;
	}

?>
