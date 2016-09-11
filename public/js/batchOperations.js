$(document).ready(function() {
	$('.status').on('change', function() {
		$(this)
			.closest('.form-group')
			.find(':checkbox')
			.prop('checked', true);
	});
});