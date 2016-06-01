<!DOCTYPE html>

<?php
	include('functions.php');

	$ip = $_SERVER['REMOTE_ADDR'];
	$video = $_GET['file'];
	$url = "";

	$tmp = split("/", $video);
	$name = $tmp[count($tmp)-1];

        if($_ENV["server"]["host"] != "localhost" && $_ENV["server"]["host"] != "127.0.0.1") {
                executeCommand("sudo ip route add $ip via 192.168.1.1 dev eth0");
                $url = getUrl($video);
        } else {
		$url = $video;
	}
?>

<html data-cast-api-enabled="true">
  <head>
    <title>
	Media Player - Playing <?php echo $name;?>
	</title>

    <!-- stylesheets -->
    <link href="styles/video-js.css" rel="stylesheet" type="text/css">
    <link href="styles/videojs.chromecast.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
        <link rel="stylesheet" type="text/css" href="styles/font-awesome.css">

    <!-- javascripts -->
    <script src="http://www.gstatic.com/cv/js/sender/v1/cast_sender.js"></script>

    <script src="js/video.dev.js"></script>
    <script src="js/videojs.chromecast.js"></script>

  </head>
  <body class="player">
	<div class="header"><?php echo $name;?></div>

    <video id="demo_player" class="video-js vjs-default-skin" controls preload="auto" width="100%" height="480" data-setup="{}">
      	<?php
		echo "<source src='".$url."' type='video/mp4'>";
	?>
      
      <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
    </video>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
      videojs("demo_player", {
        plugins: {
          chromecast: {
            appId: undefined,
            metadata: {
              title: "<?php echo $name;?>",
              //subtitle: "Subtitle"
            }
          }
        }
      });
    });
    </script>
  </body>
</html>
