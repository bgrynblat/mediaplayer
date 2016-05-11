<?php
	include('config.php');

	$str = exec("df --output=target,pcent,source | sed -e's/  */ /g' | tr \"\\n\" \"|\"");
        //$percent = explode("%", $str)[0];
        //$percent = explode("/", $percent)[1];
        

	$out = '{"storages":[';

	$split = explode("|", $str);
	foreach($split as $line) {
		foreach($_ENV["STORAGES"] as $mnt) {
			if(strpos($line, $mnt." ") !== false)
				$out = $out."\"$line\",";
		}
	}

	$out = rtrim($out, ",");
	$out = $out.']}';

	header('Content-Type: application/json');

	echo $out;

	/*echo "<div style='border: 1px solid #cccccc; height:20px;'>";
        //echo "<div style='float: right;'>".$str."</div>";
        echo "<div style='float: right;'>".$percent."%</div>";
        echo "<div style='float: left;width: ".$percent."%; background-color: #84CC58; height:20px;'></div>";
        echo "</div>";*/
?>
