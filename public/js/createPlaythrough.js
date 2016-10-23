/**
 * Created by Lars Veldscholte on 09/10/2016.
 */

// Populate select boxes
function fill(data, select) {
	$.each(data, function(i, row) {
		select.append($('<option>')
			.text(row.label)
			.attr('value', row.id));
	});
}

$(document).ready(function() {
	$(':radio').on('change', function() {
		// Disable both
		$('.playable').prop('disabled', true);

		// Enable the one next to the clicked radio button
		$(this)
			.closest('.form-group')
			.find('select')
			.prop('disabled', false);
	});

	$('#isEnded').click(function() {
		$('#ended_at').prop('disabled', !this.checked);
	});

	$('#updateStatus').click(function() {
		$('#status').prop('disabled', !this.checked);
	});
});