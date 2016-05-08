<?php
	include('config.php');

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
			} else if(is_dir($f)) {
				$arr = getFilesRecursively("$folder/$f", $origin);
				foreach($arr as $a) {
					$file = array();
                                        array_push($file, "$origin/$f/$a[0]");
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
		//array_splice($array, 0, count($array)-1);
		//echo $array[1];

		return $array;
	}

?>
