$(document).ready(function() {
	$('#selectall').click(function () {
		$('.table tbody tr')
			.find(':checkbox')
			.prop('checked', this.checked);
	});
});