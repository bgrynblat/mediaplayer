<!DOCTYPE html>

<?php
	include('config.php');

	$video = $_GET['file'];
	$video_url = $_ENV['DL_FOLDER']."/".$video;
	
	$url = "download.php?file=".$video;
	$url_dl = $url."&mode=1";
?>

<html data-cast-api-enabled="true">
  <head>
    <title>Demo - VideoJS Chromecast Plugin</title>

    <!-- stylesheets -->
    <link href="styles/video-js.css" rel="stylesheet" type="text/css">
    <link href="styles/videojs.chromecast.css" rel="stylesheet" type="text/css">

    <!-- javascripts -->
    <script src="http://www.gstatic.com/cv/js/sender/v1/cast_sender.js"></script>

    <script src="js/video.dev.js"></script>
    <script src="js/videojs.chromecast.js"></script>
  </head>
  <body>
    <video id="demo_player" class="video-js vjs-default-skin" controls preload="auto" width="640" height="360"
        poster="http://video-js.zencoder.com/oceans-clip.png"
        data-setup="{}">
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
              title: "Title",
              subtitle: "Subtitle"
            }
          }
        }
      });
    });
    </script>
  </body>
</html>
