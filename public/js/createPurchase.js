/**
 * Created by Lars Veldscholte on 24-7-2016.
 */

$(document).ready(function() {
	// Remove rows
	$('.form-horizontal').on('click', '.deleteRow', function() {
		$(this).closest('tr').remove();
	});

	var gameCounter = 0;
	// Clone new rows from template
	$('#addGame').click(function() {
		// Clone template, replace $i with auto-increment id, add new class
		$('#gameTemplate').clone()
			.removeAttr('id')
			.html(function(i, oldHTML) {
				return oldHTML.replace(/\$i/g, gameCounter);
			})
			.appendTo('#gameContainer');
		gameCounter++;
	});

	var dlcCounter = 0;
	$('#addDlc').click(function() {
		$('#dlcTemplate').clone()
			.removeAttr('id')
			.html(function(i, oldHTML) {
				return oldHTML.replace(/\$i/g, dlcCounter);
			})
			.appendTo('#dlcContainer');
		dlcCounter++;
	});
});

// jQuery UI autocomplete
// Documentation: https://jqueryui.com/autocomplete/#categories
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_create: function() {
		this._super();
		this.widget().menu('option', 'items', '> :not(.ui-autocomplete-category)');
	},
	_renderMenu: function(ul, items) {
		var that = this,
			currentCategory = "";
		$.each(items, function(index, item) {
			var li;
			if(item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				currentCategory = item.category;
			}
			li = that._renderItemData(ul, item);
			if (item.category) {
				li.attr('aria-label', item.category + ' : ' + item.label);
			}
		});
	}
});

function registerAutocomplete(data) {
	$('.form-horizontal').on('focusin', '.autocomplete', function() {
		$('.autocomplete').catcomplete({
			delay: 0,
			source: data
		});
	});
}