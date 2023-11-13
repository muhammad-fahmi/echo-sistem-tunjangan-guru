$.notify.addStyle("mynotif", {
	html:
		"<div>" + '<div class="message"><span data-notify-html/></div>' + "</div>",
	classes: {
		base: {
			"min-width": "230px",
			"max-width": "300px",
			"background-color": "white",
			padding: "10px",
			"border-radius": "4px",
			border: "2px solid #777777",
		},
		success: {
			"background-color": "#5cb85c",
			border: "2px solid #217921",
			color: "white",
		},
		error: {
			"background-color": "#d9534f",
			border: "2px solid #862522",
			color: "white",
		},
		info: {
			"background-color": "#337ab7",
			border: "2px solid #1c466b",
			color: "white",
		},
	},
});
$.notify.defaults({
	autoHide: true,
	autoHideDelay: 10000,
	style: "mynotif",
	gap: 4,
});

function map_tile(provider = "google") {
	var cur_year = new Date().getFullYear();
	if (provider == "google") {
		var mappingTiles = L.tileLayer(
			"http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}",
			{
				attribution: "Google Maps &#169; " + cur_year + "",
				maxZoom: 22,
				subdomains: ["mt0", "mt1", "mt2", "mt3"],
			}
		);
	} else {
		var mappingTiles = L.tileLayer(
			"https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
			{
				attribution:
					'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
				maxZoom: 19,
			}
		);
	}
	return mappingTiles;
}

/** fungsi untuk remove item dalam array by value */
function removeFromArr(arr) {
	var what,
		a = arguments,
		L = a.length,
		ax;
	while (L > 1 && arr.length) {
		what = a[--L];
		while ((ax = arr.indexOf(what)) !== -1) {
			arr.splice(ax, 1);
		}
	}
	return arr;
}

/** fungsi untuk hitung durasi tahun dari datetime awal dd/mm/yyyy */
function date_plus_year(start_date = "", addition = 0) {
	if (
		start_date != null &&
		start_date != undefined &&
		start_date != "" &&
		addition != null &&
		addition != undefined &&
		addition != ""
	) {
		// convert ke dalam format yyyy-mm-dd
		var b = start_date.split("/");
		var c = b[2] + "-" + b[1] + "-" + b[0];
		var d = new Date(c);
		d.setFullYear(d.getFullYear() + parseInt(addition));
		var yyyy = d.getFullYear();
		var mm = String(d.getMonth() + 1).padStart(2, "0");
		var dd = String(d.getDate()).padStart(2, "0");
		return dd + "/" + mm + "/" + yyyy;
	} else {
		return "";
	}
}

function toast(color_class = "info", message = "") {
	message = message == "" ? "" : "";
	template =
		'<div class="toast show mb-2 text-white bg-' +
		color_class +
		' border-0" role="alert" aria-live="assertive" aria-atomic="true">' +
		'<div class="d-flex align-items-center">' +
		'<div class="toast-body">' +
		'<div class="d-flex align-items-center">' +
		'<i data-feather="info" class="fill-white feather-sm me-2"></i>' +
		message +
		"</div>" +
		"</div>" +
		'<button type="button" class="btn-close btn-close-white ms-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>' +
		"</div>" +
		"</div>";
}
