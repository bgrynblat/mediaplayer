function updateFiles() {
	$.get("update_files.php", function(data) {
		var content = $("#files")[0].children[1];
		console.log(data.files);

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
