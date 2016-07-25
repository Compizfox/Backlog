/**
 * Created by Lars Veldscholte on 24-7-2016.
 */

$(document).ready(function() {
	// Remove rows
	$('.form-horizontal').on('click', '.deleteRow', function() {
		$(this).closest('.form-group').remove();
	});

	var gameCounter = 0;
	// Clone new rows from template
	$('#addGame').click(function() {
		// Clone template, remove style and id, replace $i with auto-increment id, add new class
		$('#gameTemplate').clone()
			.removeAttr('style id')
			.attr('class', 'form-group')
			.html(function(i, oldHTML) {
				return oldHTML.replace(/\$i/g, gameCounter);
			})
			.appendTo('#gameContainer');
		gameCounter++;
	});

	var dlcCounter = 0;
	$('#addDlc').click(function() {
		$('#dlcTemplate').clone()
			.removeAttr('style id')
			.attr('class', 'form-group')
			.html(function(i, oldHTML) {
				return oldHTML.replace(/\$i/g, dlcCounter);
			})
			.appendTo('#dlcContainer');
		gameCounter++;
	});
});