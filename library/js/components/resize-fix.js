define(['jquery', 'vendor/modernizr'], function( $ ) {

	// defined modernizr because we need to make sure that the CSS paints after modernizr loads

	// make the widgets absolute rather than fixed if they have too many children

	var rtime = new Date(1, 1, 2000, 12,0,0);
	var timeout = false;
	var delta = 200;

	// set sidebar to pos abs if it's not okay to fix it.
	function sidebarHeightFix() {

		sidebar = $('#blog-sidebar');
		if (sidebar.length) {
			sidebarHeight = $('#blog-sidebar').offset().top + sidebar.outerHeight();
			if ($(window).width() < 701) { 
				sidebar.css('position', 'relative'); 
				return;
			}
			else if (sidebarHeight > $(window).height()) {
				sidebar.css('position', 'absolute');
				return;
			} else {
				sidebar.css('position', 'fixed');
				return;
			}
		} else {
			return;
		}
	}



	function featureboxMatchingHeights() {

		if ($(window).width() < 700) {
			return;
		}

		
		$.each( $('.cf_columns'), function(index, element) {

			

			var t = 0;
			var t_elem;

			
			
			$.each( $(element).find('.feature.has-content'), function(index, child) {

				if ($(child).outerHeight() > t) {

					
					t_elem = child;
					t = $(child).outerHeight();
				}

				
				
			});

			$(element).find('.feature.has-content').css('height', t);

			
			

		});
	}

	// used below for resize throttling
	function resizeend( callback, args ) {
	    if (new Date() - rtime < delta) {
	        setTimeout(function() {
		        	resizeend( callback, args );
		        	featureboxMatchingHeights();
		        }, delta);
	    } else {
	        timeout = false;
	        callback(args);
	    }               
	}

	
	// general resize callback thing.  Add new callback with other things if you want lots of resize events.
	$(document).ready( function() {

		sidebarHeightFix(); // fire on load
		
		featureboxMatchingHeights();
		

		$(window).resize( function() {

			rtime = new Date();
			if (timeout === false) {
	        timeout = true;
		        setTimeout(function() {
		        	resizeend(sidebarHeightFix); // , args if needed
		        }, delta);
		    }

		} );
	});


});