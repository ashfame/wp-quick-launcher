(function($){
	$(document).ready(function(){
		var ql = adminQuickLauncher || {};

		ql.addOverlay = function(){
			var docHeight = $(document).height();
			$('body').append('<div id="ql-overlay"></div>');

			$('#ql-overlay').height(docHeight).css({
				'opacity' : 0.4,
				'position': 'absolute',
				'top': 0,
				'left': 0,
				'background-color': 'black',
				'width': '100%',
				'z-index': 5000
			});
		};

		ql.killOverlay = function() {
			$('#ql-overlay').remove();
		};

		ql.bindEvents = function(){
			$.hotkeys.add('Ctrl+shift+a',ql.showLauncher);
			$.hotkeys.add('esc',ql.hideLauncher);
			$(document).keypress(function(e) {
				if ( e.which == 13 && e.target == document.getElementById('adminQuickLauncher') ) {
					ql.processLaunchInput();
				}
			});
		};

		ql.showLauncher = function(){
			ql.addOverlay();
			$('#adminQuickLauncher').show().val('').focus();
		};

		ql.hideLauncher = function() {
			ql.killOverlay();
			$('#adminQuickLauncher').hide();
		};

		ql.processLaunchInput = function() {
			var input = $('#adminQuickLauncher').val();
			var parsedInput = input.replace(/\s+/g, '-').toLowerCase().replace(/(\d+)/g,'%'); // replace all spaces with dash and number with %
			console.log( parsedInput );
			console.log( ql.registeredShortcuts.parsedInput );
			$.each( ql.registeredShortcuts, function(shortcut,href){
				if ( shortcut == parsedInput ) {
					if ( href.indexOf('%') != -1 ) {
						var number = input.replace( /^\D+/g, ''); // get number out of string
						window.location.href = href.replace('%',number);
					} else {
						window.location.href = href;
					}
				}
			});
		};

		ql.bindEvents();
	});
})(jQuery);