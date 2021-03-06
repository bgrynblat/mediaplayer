var jobs = "";
var storages = "";

function start() {
	updateFiles();
	updateJobs(true);
	updateStatus();
}

function prettyFilename(fn) {
	if(/.*S[0-9][0-9]E[0-9][0-9].*/.test(fn)) {
		var t = fn.match(/S[0-9][0-9]E[0-9][0-9]/g);
		var split = fn.split(t[0]);
		var show = split[0].replace(/\./g, " ")+" "+t[0];	
		return show;
	} else {
		var tmp = fn.replace(/\./g, " ");
		var split = tmp.split(" ");
		var nfn = "";
		split.forEach(function(word) {
			if(word != split[split.length-1])
				nfn+=word+" ";
		});
		return nfn;
	}
}

function getFormat(fn) {
	var spl = fn.split(".");
	return spl[spl.length-1].toUpperCase();
}

function updateFiles() {
	var i = $('#updfiles');
	i.toggleClass("load");
	$.get("update_files.php?force=true", function(data) {
		var content = $("#files")[0].children[1];

		content.innerHTML = "";

		if(data.files.length == 0) content.innerHTML = "No files found !";

		var id=0;
		data.files.forEach(function(file) {
			id++;

			var prettyfilename = prettyFilename(file["filename"]);

			content.innerHTML += "<div class='file fileid"+id+"' onclick='toggleDetails(\""+id+"\")' ondragstart='dragEvent(event)' id='"+file["url"]+"' draggable='true'>"+prettyfilename+
						"<a id='deletebtn"+id+"' class='delete' onclick='deleteFile(\""+file["url"]+"\", "+id+");'><i class='fa fa-remove'></i></a>"+
						"<a class='play' href='videoplayer.php?file="+file["url"]+"'><i class='fa fa-play'></i></a>"+
						"<a class='download' download='' target='_blank' href='download.php?file="+file["url"]+"&amp;mode=1'><i class='fa fa-cloud-download'></i></a>"+
						"<div class='filedetail hidden' id='filedetail"+id+"'>Size : "+file["size"]+" Format : "+getFormat(file["url"])+"</div>"+
						"</div>";
		});

	}).fail(function(data) {
		console.log("error...");
	}).done(function() {
		setTimeout(updateStatus, 60000, true);
		i.toggleClass("load");
	});
}

function toggleDetails(id) {
	var i = $('#filedetail'+id);
	i.toggleClass("hidden");
}

function dragEvent(ev) {
	ev.dataTransfer.setData("text", ev.target.id);
	var id = 0;
	ev.target.classList.forEach(function(c) {
		if(/fileid.*/.test(c))
			id = c;
	});
	ev.dataTransfer.setData("id", id);
	console.log(ev);
}

function dropEvent(ev) {
	ev.preventDefault();
	var file=ev.dataTransfer.getData("text");
	var id=ev.dataTransfer.getData("id");
	var dest = ev.target.id;

	if(dest != "/") {
		var div=$('.'+id)[0];
		console.log(div);
		var content = div.innerHTML;

		div.innerHTML = file+" - Copy in progress... <i class='fa fa-refresh load'></i>";

		$.get("move_file.php?file="+file+"&dest="+dest, function(data) {
			console.log(data);
		}).fail(function(data) {
        	        console.log("error...");
			div.innerHTML = content;
        	}).done(function() {
			console.log("Done !");
			setTimeout(updateFiles, 40000);
        	});
	} else console.log("Not allowed");
}

function updateJobs(auto) {

        $.get("update_jobs.php", function(data) {
                var content = $("#jobs")[0].children[1];

		content.innerHTML = "";

		if(data.jobs.length == 0) content.innerHTML = "No active jobs !";
		jobs = data.jobs;
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
			str += "<a class='delete' onclick='actionJob(\"remove\", \""+id+"\");'><i class='fa fa-remove'></i></a>";

			if(status == "Stopped")
				str += "<a class='play' onclick='actionJob(\"start\", \""+id+"\");'><i class='fa fa-play'></i></a>";
			else
				str += "<a class='pause' onclick='actionJob(\"stop\", \""+id+"\");'><i class='fa fa-pause'></i></a>";

			str += "<div class='progress-bar' style='width: "+pcent+"'></div></div>";

                	content.innerHTML += str;
                });
        }).fail(function(data) {
                console.log("error...");
	}).done(function() {
		if(auto)	setTimeout(updateJobs, 10000, true);
	});
}

function actionJob(action, id) {
	$.get("action_torrent.php?action="+action+"&id="+id, function(data) {
                updateJobs(false);
        }).fail(function(data) {
                console.log("error...");
        });
}

function actionAll(action) {
	jobs.forEach(function(job) {
		var id = job["job"].split(";")[0];
		actionJob(action, id);
	});
}

function deleteFile(file, id) {

	var f = $('#deletebtn'+id)[0];

	f.innerHTML="<i class='fa fa-refresh load'></i>";
	$.get("delete_file.php?file="+file, function(data) {
                updateFiles();
		updateStatus();
        }).fail(function(data) {
                console.log("error...");
        });
}

function allowDrop(ev) {
    ev.preventDefault();
}

function updateStatus() {
	$.get("check_status.php", function(data) {
		var content = $("#status")[0].children[1];
		var form = $("#storage_list")[0];

                content.innerHTML = "";
		form.innerHTML = "";

		//var json = jQuery.parseJSON("'"+data+"'");
		//console.log(json);

                if(data.storages.length == 0) content.innerHTML = "Error fetching status !";
		storages = data.storages;
                data.storages.forEach(function(storage) {
                        var array = storage.mnt.split(" ");
                        var mnt = array[0];
                        var pcent = array[1];
                        var dev = array[2];

			if(storage.mounted) {

				var str = "<div class='storage' id='"+mnt+"' ondrop='dropEvent(event)' ondragover='allowDrop(event)' style='border: 1px solid #cccccc; height:20px;'>";
				str += "<div id='"+mnt+"' style='float: right;'>"+dev+" - "+pcent+"</div>";
				str += "<div id='"+mnt+"' style='float: left;width: "+pcent+"; background-color: #84CC58; height:20px;'></div>";
				str += "</div>";

                        	content.innerHTML += str;
			}
			else form.innerHTML += "<option value=\""+mnt+"\">"+mnt+"</option>";
                });

		if(data.vpn != undefined) {
			var vpn = $(".vpn")[0];

			if(data.vpn.present) {
				var str = "<span>VPN :	</span>";
				str += '<div id="vpn-toggle" class="toggle-button';
				if(data.vpn.status)	str += " toggle-button-selected";
				str += '" onclick="toggleVPN()"><button></button></div>';
				str += "<span>"+data.vpn.type.toUpperCase()+" </span>";

				str += "<br/><span>Force : </span>";
				str += '<div id="vpn-toggle" class="toggle-button';
                                if(data.vpn.force)     str += " toggle-button-selected";
                                str += '" onclick="toggleVPNForce()"><button></button></div>';
				if(data.vpn.force)     str += "<span>Always download via VPN</span>";

			} else	str += "<span>VPN not configured</span>"

			vpn.innerHTML = str;
		}

        }).fail(function(data) {
                console.log("error...");
        });
}

function toggleVPN() {
	var vpn = $("#vpn-toggle")[0];
	var content = vpn.innerHTML;

	vpn.innerHTML = "<i class='fa fa-refresh load'></i>";

	$.get("toggle_vpn.php", function(data) {
		setTimeout(updateStatus(), 5000);
		
	}).fail(function(data) {
                console.log("error...");
		vpn.innerHTML = content;
        });
}

function toggleVPNForce() {
	$.get("toggle_vpn.php?force=true", function(data) {
		setTimeout(updateStatus(), 2000);
        }).fail(function(data) {
                console.log("error...");
        });
}
