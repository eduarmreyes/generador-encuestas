$(document).on("ready", function() {
	$('.btn, .btn-primary').click(function() {
		$(this).button('loading');
	});
});