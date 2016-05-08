<?php
	include('functions.php');
?>

<html>
<head>
	<title>Media player</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">-->
</head>
<body>

<div class="header">HELLO BEN !</div>

<div class="section">
<h2>FILES</h2>
<div class='content'>
<?php
	$files = getFiles();
	foreach ($files as $result) {
		echo "<div class='file'>";
		echo $result[2];
		echo "<a class='delete' href='delete_file.php?file=".$result[0]."'><i class='fa fa-remove'>DELETE</i></a>";
    		echo "<a class='play' href='videoplayer.php?file=".$result[0]."'><i class='fa fa-play'>PLAY</i></a>"; 
    		echo "<a class='download' download target='_blank' href='download.php?file=".$result[0]."&mode=1'><i class='fa fa-cloud-download'>DOWNLOAD</i></a>"; 
    		echo "</div>";
	} 
?>
</div>
</div>

<div class="section">
<h2>CURRENT JOBS</h2>
<div class='content'>
<?php
	// ID Done Have ETA Up Down Ratio Status Name
	//1 51% 211.8 MB Unknown 0.0 0.0 0.0 Stopped The.Walking.Dead.S06E08.HDTV.x264-KILLERS[eztv].mp4
	$jobs = checkJobs();
	//$jobs=$j[0];
	//$jobs_percent=$j[1];
	if(empty($jobs)) {
		echo "No jobs running !";
	} else {
		for($i=1; $i<count($jobs); $i++) {
			$job = $jobs[$i];
			$array = explode(" ", $job);
	
			$id = $array[0];
			$pcent = $array[1];
			$status = $array[8];
			$torrent = $array[count($array)-1];

			echo "<div class='current_job'>";
                        echo $torrent." (".$id." | ".$pcent.")";
                        echo "<a class='pause' href='stop_job.php?job=".$id."'><i class='fa fa-pause'></i></a>";
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
