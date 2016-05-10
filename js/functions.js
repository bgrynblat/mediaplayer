function start() {
	updateFiles();
	updateJobs();

	setInterval(updateJobs, 10000);
}

function updateFiles() {
	$.get("update_files.php", function(data) {
		var content = $("#files")[0].children[1];

		content.innerHTML = "";

		data.files.forEach(function(file) {
			content.innerHTML += "<div class='file'>"+file["filename"]+"<a class='delete' href='delete_file.php?file="+file["url"]+"'><i class='fa fa-remove'></i></a>"+
						"<a class='play' href='videoplayer.php?file="+file["url"]+"'><i class='fa fa-play'></i></a>"+
						"<a class='download' download='' target='_blank' href='download.php?file="+file["url"]+"&amp;mode=1'><i class='fa fa-cloud-download'></i></a>"+
						"</div>";
		});

	}).fail(function(data) {
		console.log("error...");
	});
}

function updateJobs() {
        $.get("update_jobs.php", function(data) {
                var content = $("#jobs")[0].children[1];

		content.innerHTML = "";

                data.jobs.forEach(function(job) {
			var array = job["job"].split(";");

			var id = array[0];
			id = id.replace("*", "");

			var pcent = array[1];
			var up = array[4];
			var down = array[5];
			var status = array[7];
			var name = array[array.length-1];

                	content.innerHTML += "<div class='current_job'>"+name+" ("+pcent+" | <i class='fa fa-arrow-down'></i> "+down+" kb/s | <i class='fa fa-arrow-up'></i> "+up+" kb/s | "+status+")"
						+"<a class='delete' href='remove_torrent.php?id="+id+"'><i class='fa fa-remove'></i></a><a class='play' href='start_torrent.php?id="+id+"'><i class='fa fa-play'></i></a>"
						+"<div class='progress-bar' style='width: "+pcent+"'></div></div>";
                });

        }).fail(function(data) {
                console.log("error...");
        });
}
