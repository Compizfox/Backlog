/**
 * Created by Lars Veldscholte on 04/09/2016.
 */

$(document).ready(function() {
	// Remove rows
	$('table').on('click', '.fa-chain-broken', function() {
		$(this).closest('tr').remove();
	});

	// Add members
	$('#game, #dlc').on('change', function() {
		// Don't add the default placeholder
		if($(this).val() === "") return;

		// Clone row from templace
		var row = $('#template tr').clone();

		// Change attributes
		var input = row.find('input');
		if($(this).attr('id') == 'game') input.attr('name', 'games[]');
		if($(this).attr('id') == 'dlc') input.attr('name', 'dlc[]');
		input.attr('value', $(this).val());

		row.children('#name')
		   .text($(this).find('option:selected').text());

		// Append row to table
		row.appendTo('form tbody');
	});
});

// Populate select boxes
function fillGames(data) {
	var select = $('#game');
	$.each(data, function(i, row) {
		var option = $('<option>').text(row.label)
		                          .attr('value', row.id);

		if(select.children("optgroup[label='" + row.category + "']").length === 0) {
			select.append($('<optgroup>')
			      .attr('label', row.category));
		}

		select.children("optgroup[label='" + row.category + "']")
		      .append(option);
	});
}

function fillDlc(data) {
	var select = $('#dlc');

	$.each(data, function(i, row) {
		select.append($('<option>')
		      .text(row.label)
		      .attr('value', row.id));
	});
}