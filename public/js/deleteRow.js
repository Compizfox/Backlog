/**
 * Created by Lars Veldscholte on 26-7-2016.
 */

$(document).ready(function() {
	$('.delete').click(function() {
		$('#modalForm').attr('action', $(this).data('url'));
		$('#myModal').modal();
	});
});