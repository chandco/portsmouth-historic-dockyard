
define(['jquery', 'vendor/slick'], function($) {
  
  $(document).ready( function() {


	  $('.cycle-slideshow').slick({
	  		slide: 'div',
	  		autoplay: true,
	  	//	prevArrow: '.cycle-prev',
	  	//	nextArrow: '.cycle-next',
	  		lazyLoad: 'ondemand',
	  		dots: true,
	  });  

	});
});