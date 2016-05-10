<?php
	include('functions.php');
?>

<html>
<head>
	<title>Media player</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/font-awesome.css">

    	<script src="js/jquery-2.2.3.min.js"></script>
    	<script src="js/functions.js"></script>
</head>
<body onload="updateFiles()">

<div class="header">HELLO BEN !</div>

<div class="section" id="files">
	<h2>FILES <a onclick="updateFiles()"><i class='fa fa-refresh'></i></a></h2>
	<div class='content'></div>
</div>

<div class="section">
<h2>CURRENT JOBS</h2>
<div class='content'>
<?php
	// ID Done Have ETA Up Down Ratio Status Name
	//1;51%;211.8 MB;Unknown;0.0;0.0;0.0;Stopped;The.Walking.Dead.S06E08.HDTV.x264-KILLERS[eztv].mp4
	$jobs = checkJobs();
	//$jobs=$j[0];
	//$jobs_percent=$j[1];
	if(count($jobs) <= 1) {
		echo "No jobs running !";
	} else {
		for($i=1; $i<count($jobs); $i++) {
			$job = $jobs[$i];
			$array = explode(";", $job);
	
			$id = $array[0];
			$id = str_replace("*", "", $id);
			$pcent = $array[1];
			$up = $array[4];
			$down = $array[5];
			$status = $array[7];
			$torrent = $array[count($array)-1];

			echo "<div class='current_job'>";
                        echo "$torrent ($pcent | <i class='fa fa-arrow-down'></i> $down kb/s | <i class='fa fa-arrow-up'></i> $up kb/s | $status)";
			echo "<a class='delete' href='remove_torrent.php?id=".$id."'><i class='fa fa-remove'></i></a>";
			if(strcmp($status, "Stopped") == 0)
                        	echo "<a class='play' href='start_torrent.php?id=".$id."'><i class='fa fa-play'></i></a>";
			else
				echo "<a class='pause' href='stop_torrent.php?id=".$id."'><i class='fa fa-pause'></i></a>";
                        echo "<div class='progress-bar' style='width: ".$pcent."'></div>";
                        echo "</div>";
		}
	}
?>
</div>
</div>

<div class="section">
<h2>STATUS</h2>
<div class='content'>
<?php
	$str = exec("df --output=target,pcent,source | grep /dev/ | grep \"/ \"");
	$percent = explode("%", $str)[0];
	$percent = explode("/", $percent)[1];
	echo "<div style='border: 1px solid #cccccc; height:20px;'>";
	//echo "<div style='float: right;'>".$str."</div>";
	echo "<div style='float: right;'>".$percent."%</div>";
	echo "<div style='float: left;width: ".$percent."%; background-color: #84CC58; height:20px;'></div>";
	echo "</div>";
?>
</div>
</div>

<div class="section">
<h2>SEARCH TORRENT</h2>
<div class='content'>
<form action="search_torrent.php" method="get">
        <label for="search">Torrent name :</label>
        <input id="search" name="search" type="text"></input>
        <input type="submit" value="Search"></input>
</form>
</div>
</div>

<div class="section">
<h2>IMPORT TORRENT</h2>
<div class='content'>
<form action="import_torrent.php" method="get">
        <label for="torrent">Torrent URL :</label>
        <input id="torrent" name="torrent" type="text"></input>
        <input type="submit" value="Start"></input>

</form>
</div>
</div>

</body>
</html>
