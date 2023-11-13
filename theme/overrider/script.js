function toaster(color_class = "info", message = "") {
	switch (color_class) {
		case "success":
			icon_txt = "fas fa-check-square";
			break;
		case "danger":
			icon_txt = "fas fa-exclamation-triangle";
			break;
		default:
			icon_txt = "fas fa-info-circle";
			break;
	}
	let message_txt =
		message == "" ? "This is an auto-generated message " : message;
	let id = $.now();
	template =
		'<div id="' +
		id +
		'" class="toast mb-2 text-white bg-' +
		color_class +
		' border-1 border-white" role="alert" aria-live="assertive" aria-atomic="true">' +
		'<div class="d-flex align-items-center">' +
		'<div class="toast-body">' +
		'<div class="d-flex align-items-center">' +
		'<i class="' +
		icon_txt +
		' me-2"></i>' +
		message_txt +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>";

	$(".toast_container").append(template);
	$("#" + id).addClass("show");
	setTimeout(() => {
		$("#" + id).removeClass("show");
	}, 7800);
	setTimeout(() => {
		$("#" + id).remove();
	}, 8000);
}
