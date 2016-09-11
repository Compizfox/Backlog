$(document).ready(function() {
	$('.selectall').click(function () {
		$(this)
			.closest('table')
			.find(':checkbox')
		    .prop('checked', this.checked);
	});
});