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

function show_notify(status, message) {
	let icon, title;
	switch (status) {
		case "success": {
			icon = '<i class="fas fa-check-circle me-1"></i>';
			title = "Sukses!";
			break;
		}
		case "info": {
			icon = '<i class="fas fa-info-circle me-1"></i>';
			title = "Info";
			break;
		}
		default: {
			title = "Gagal!";
			icon = '<i class="fas fa-exclamation-triangle me-1"></i>';
			break;
		}
	}
	$.notify("<b>" + icon + title + "</b><br>" + message, status);
}

function on_dev() {
	show_notify("info", "Maaf, proses ini masih dalam tahap pengembangan.");
}

/**
 * Initializes a Select2 dropdown with AJAX-based search and optional extra parameters.
 *
 * @function init_select2
 * @param {string} d_element_selector - jQuery selector for the element to be initialized as Select2.
 * @param {string} d_placeholder - Placeholder text to show in the Select2 input.
 * @param {string} d_url - URL endpoint to fetch AJAX search results (expects JSON).
 * @param {Function} [extraDataFn=() => ({})] - Optional function that returns an object
 *        of additional parameters to be sent with each AJAX request.
 *
 * @example
 * init_select2('#f_kecamatan', 'Cari Kecamatan...', '/api/search_kecamatan');
 *
 * @example
 * init_select2('#f_sekolah', 'Pilih Sekolah', '/api/sekolah', () => ({
 *   tahun: $('#filter_tahun').val()
 * }));
 */
function init_select2(
	d_element_selector,
	d_placeholder,
	d_url,
	extraDataFn = () => ({})
) {
	$(d_element_selector).select2({
		allowClear: false,
		placeholder: d_placeholder,
		ajax: {
			type: "POST",
			dataType: "json",
			url: d_url,
			delay: 800,
			data: function (params) {
				return {
					search: params.term,
					...extraDataFn(), // ← dynamically merged when request is made
				};
			},
			processResults: function (data) {
				return {
					results: data,
				};
			},
		},
	});
}

/**
 * Creates a debounced version of a function.
 *
 * @param {Function} fn - The function to debounce.
 * @param {number} delay - Delay in milliseconds before `fn` is executed.
 * @returns {Function} A debounced version of `fn`.
 */
function debounce(fn, delay) {
	let timer = null;
	return function (...args) {
		clearTimeout(timer);
		timer = setTimeout(() => fn.apply(this, args), delay);
	};
}
