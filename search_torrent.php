<?php

if(!isset($_GET['search']))
	exit();

$search = str_replace(" ", "-", $_GET['search']);

exec("scripts/search_torrent.sh $search");
?>

<html>
<head>
<script language="javascript">
	var names = function(e){
		var list = document.getElementsByTagName("a");
		var i;
		for(i = 0; i<list.length; ++i) {
			var entry = list[i];
			entry.innerHTML = entry.title;
			entry.href = "import_torrent.php?torrent="+entry.href;
		}
	}
</script>
</head>
<body onload="names();">
<?php

$handle = fopen("tmps/$search.links", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
	echo "$line<br/>";
    }

    fclose($handle);
} else {
	echo "ERROR";
} 

?>

</body>
</html>
