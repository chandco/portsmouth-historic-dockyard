define(['jquery', 'vendor/magnific-popup'], function($) {

	$(document).ready( function() {
		$('.popup-button').magnificPopup({
		 
		  items: {
		  	src: $('.popup-button').siblings('.popup'),
		  	type:'inline',
		  },
		  midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
		});

		$('a[rel="gallery[lightbox]"]').magnificPopup({
                    type:'image', 
                    
                    gallery:
                        {
                            enabled:true
                        },// gallery:{
                    removalDelay: 300,
                    mainClass: 'mfp-fade'  

                });


		$('.gallery').magnificPopup({
                    type:'image', 
                    delegate: 'a', 
                    gallery:
                        {
                            enabled:true
                        },// gallery:{
                    removalDelay: 300,
                    mainClass: 'mfp-fade'  

        });
	});
});



