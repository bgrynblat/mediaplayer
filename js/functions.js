function start() {
	updateFiles();
	updateJobs(true);
	updateStatus();
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

function updateJobs(auto) {

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
	}).done(function() {
		if(auto)	setTimeout(updateJobs, 10000, true);
		updateStatus();
	});
}

function stopJob(id) {
	$.get("stop_torrent.php?id="+id, function(data) {
                updateJobs(false);
        }).fail(function(data) {
                console.log("error...");
        });
}

function resumeJob(id) {
	$.get("start_torrent.php?id="+id, function(data) {
		updateJobs(false);
        }).fail(function(data) {
                console.log("error...");
        });
}

function deleteJob(id) {
	$.get("remove_torrent.php?id="+id, function(data) {
                updateJobs(false);
        }).fail(function(data) {
                console.log("error...");
        });
}

function deleteFile(file) {
	$.get("delete_file.php?file="+file, function(data) {
                updateFiles();
		updateStatus();
        }).fail(function(data) {
                console.log("error...");
        });
}

function updateStatus() {
	$.get("check_status.php", function(data) {
		var content = $("#status")[0].children[1];

                content.innerHTML = "";

                if(data.storages.length == 0) content.innerHTML = "Error fetching status !";

                data.storages.forEach(function(mnt) {
                        var array = mnt.split(" ");

                        var mnt = array[0];
                        var pcent = array[1];
                        var dev = array[2];

			var str = "<div class='storage' style='border: 1px solid #cccccc; height:20px;'>";
			str += "<div style='float: right;'>"+dev+" - "+pcent+"</div>";
			str += "<div style='float: left;width: "+pcent+"; background-color: #84CC58; height:20px;'></div>";
			str += "</div>";

                        content.innerHTML += str;
                });

        }).fail(function(data) {
                console.log("error...");
        });
}
