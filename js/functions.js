function start() {
	updateFiles();
	updateJobs();

	setInterval(updateJobs, 10000);
}

function updateFiles() {
	$.get("update_files.php?force=true", function(data) {
		var content = $("#files")[0].children[1];

		content.innerHTML = "";

		if(data.files.length == 0) content.innerHTML = "No files found !";

		data.files.forEach(function(file) {
			content.innerHTML += "<div class='file'>"+file["filename"]+"<a class='delete' onclick='deleteFile(\""+file["url"]+"\");' href='#'><i class='fa fa-remove'></i></a>"+
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

		if(data.jobs.length == 0) content.innerHTML = "No active jobs !";

                data.jobs.forEach(function(job) {
			var array = job["job"].split(";");

			var id = array[0];
			id = id.replace("*", "");

			var pcent = array[1];
			var up = array[4];
			var down = array[5];
			var status = array[7];
			var name = array[array.length-1];

			var str = "<div class='current_job'>"+name+" ("+pcent+" | <i class='fa fa-arrow-down'></i> "+down+" kb/s | <i class='fa fa-arrow-up'></i> "+up+" kb/s | "+status+")";
			str += "<a class='delete' href='#' onclick='deleteJob(\""+id+"\");'><i class='fa fa-remove'></i></a>";

			if(status == "Stopped")
				str += "<a class='play' href='#' onclick='resumeJob(\""+id+"\");'><i class='fa fa-play'></i></a>";
			else
				str += "<a class='pause' href='#' onclick='stopJob(\""+id+"\");'><i class='fa fa-pause'></i></a>";

			str += "<div class='progress-bar' style='width: "+pcent+"'></div></div>";

                	content.innerHTML += str;
                });

        }).fail(function(data) {
                console.log("error...");
        });
}

function stopJob(id) {
	$.get("stop_torrent.php?id="+id, function(data) {
                updateJobs();
        }).fail(function(data) {
                console.log("error...");
        });
}

function resumeJob(id) {
	$.get("start_torrent.php?id="+id, function(data) {
		updateJobs();
        }).fail(function(data) {
                console.log("error...");
        });
}

function deleteJob(id) {
	$.get("remove_torrent.php?id="+id, function(data) {
                updateJobs();
        }).fail(function(data) {
                console.log("error...");
        });
}

function deleteFile(file) {
	$.get("delete_file.php?file="+file, function(data) {
                updateFiles();
        }).fail(function(data) {
                console.log("error...");
        });
}
