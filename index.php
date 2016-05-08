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
		echo $result;
		echo "<a class='delete' href='delete_file.php?file=".$result."'><i class='fa fa-remove'>DELETE</i></a>";
    		echo "<a class='play' href='videoplayer.php?file=".$result."'><i class='fa fa-play'>PLAY</i></a>"; 
    		echo "<a class='download' download target='_blank' href='download.php?file=".$result."&mode=1'><i class='fa fa-cloud-download'>DOWNLOAD</i></a>"; 
    		echo "</div>";
	} 
?>
</div>
</div>

<div class="section">
<h2>CURRENT JOBS</h2>
<div class='content'>
<?php
	/*
	$j = getCurrentJobs();
	$jobs=$j[0];
	$jobs_percent=$j[1];
	if(empty($jobs)) {
		echo "No jobs running !";
	} else {
		for($i=0; $i<count($jobs); $i++) {
			$job = $jobs[$i];
			$pos = strpos($job, " ");
			$pid = substr($job, 0, $pos);
			$cmd = substr($job, $pos);
			$file = explode(" ", $cmd);			

			echo "<div class='current_job'>";
			echo $file[4]." (".$pid." | ".$jobs_percent[$i]."%)";
			echo "<a class='pause' href='stop_job.php?job=".$pid."'><i class='fa fa-pause'></i></a>";
			echo "<div class='progress-bar' style='width: ".$jobs_percent[$i]."%'></div>";
    			echo "</div>";
		}
	}
	*/
?>
</div>
</div>

<div class="section">
<h2>PAUSED JOBS</h2>
<div class='content'>
<?php
	/*
	$l = getPausedDownloads($jobs);
	$logs=$l[0];
	$logs_percent=$l[1];
	if(empty($logs)) {
                echo "No paused jobs !";
        } else {
		for($i=0; $i<count($logs); $i++) {
			$result = $logs[$i];
			echo "<div class='paused_job'>";
    			echo $result; 
			echo " (".$logs_percent[$i]."%)";
			echo "<a class='delete' href='delete_job.php?job=".$result."'><i class='fa fa-remove'></i></a>";
			echo "<a class='start' href='start_job.php?torrent=".$result."'><i class='fa fa-play'></i></a>";
			echo "<div class='progress-bar' style='width: ".$logs_percent[$i]."%'></div>";
    			echo "</div>";
		}
	}
	*/
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
<h2>START A JOB</h2>
<div class='content'>
<form action="start_job.php" method="get">
	<label for="torrent">Torrent URL :</label>
	<input id="torrent" name="torrent" type="text"></input>
	<input type="submit" value="Start"></input>

</form>
</div>
</div>

</body>
</html>
