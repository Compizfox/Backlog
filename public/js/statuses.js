/**
 * Created by Lars Veldscholte on 05/01/2017.
 */

$(document).ready(function() {
	// Remove rows
	$('form').on('click', '.deleteRow', function() {
		$(this).closest('tr')
			.fadeOut("normal", function() {
				$(this).remove();
			})
	});

	// Clone new rows from template
	$('#addRow').click(function() {
		$('#template tr')
			.clone()
			.html(function(i, oldHTML) {
				return oldHTML.replace(/\$i/g, $('#statuses tr').length);
			})
			.fadeIn("normal")
			.appendTo('#statuses');
	});
});