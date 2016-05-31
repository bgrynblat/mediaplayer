<?php
	include('functions.php');
?>

<html>
<head>
	<title>Media player</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/font-awesome.css">
	<link href="styles/toggle_button.css" rel="stylesheet">

    	<script src="js/jquery-2.2.3.min.js"></script>
    	<script src="js/functions.js"></script>
</head>
<body onload="start();">

<div class="header">HELLO BEN !</div>

<div class="section" id="files">
	<h2>FILES <a href="#" onclick="updateFiles()"><i class='fa fa-refresh'></i></a></h2>
	<div class='content'><i class='fa fa-refresh load'></i></div>
</div>

<div class="section" id="jobs">
	<h2>CURRENT JOBS 
		<a onclick="updateJobs(false)"><i class='fa fa-refresh'></i></a>
		<a onclick="actionAll('stop')"><i class='fa fa-pause'></i></a>
		<a onclick="actionAll('start')"><i class='fa fa-play'></i></a>
	</h2>
	<div class='content'><i class='fa fa-refresh load'></i></div>
</div>

<div class="section" id="status">
	<h2>STATUS</h2>
	<div class='content'><i class='fa fa-refresh load'></i></div>
	<form id="storages" action="add_storage.php" method="get">
		<select id="storage_list" name="mount"></select>	
		<input type="submit" value="Add"></input>
	</form>
	<div class='vpn'></div>
</div>

<div class="section" id="search">
<h2>SEARCH TORRENT</h2>
<div class='content'>
<form action="search_torrent.php" method="get">
        <label for="search">Torrent name :</label>
        <input id="search" name="search" type="text"></input>
        <input type="submit" value="Search"></input>
</form>
</div>
</div>

<div class="section" id="import">
<h2>IMPORT TORRENT</h2>
<div class='content'>

<form action="upload_torrent.php" method="post" enctype="multipart/form-data">
    Select torrent to upload:
    <input type="file" name="file_to_upload" id="file_to_upload">
    <input type="submit" value="Upload" name="submit">
</form>

<span>OR</span>

<form action="import_torrent.php" method="get">
        <label for="torrent">Torrent URL :</label>
        <input id="torrent" name="torrent" type="text"></input>
        <input type="submit" value="Start"></input>
</form>
</div>
</div>

</body>
</html>
