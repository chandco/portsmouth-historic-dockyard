
/*

	var keys = [37, 38, 39, 40];

	function preventDefault(e) {
	  e = e || window.event;
	  if (e.preventDefault)
	      e.preventDefault();
	  e.returnValue = false;  
	}

	function keydown(e) {
	    for (var i = keys.length; i--;) {
	        if (e.keyCode === keys[i]) {
	            preventDefault(e);
	            return;
	        }
	    }
	}


	function wheel(e) {
	  preventDefault(e);
	}

	function disable_scroll() {
	  if (window.addEventListener) {
	      window.addEventListener('DOMMouseScroll', wheel, false);
	  }
	  window.onmousewheel = document.onmousewheel = wheel;
	  document.onkeydown = keydown;
	}

	function enable_scroll() {
	    if (window.removeEventListener) {
	        window.removeEventListener('DOMMouseScroll', wheel, false);
	    }
	    window.onmousewheel = document.onmousewheel = document.onkeydown = null;  
	}
*/


define(['jquery'], function($) {

	$menu.find('.nav').attr("id","popup-menu");
	$menu.appendTo("#popup-menu-container");

	$("#navigation-dropdown").click(function(e) {
        e.preventDefault();
        $("body").toggleClass("navigation-menu-open");

        var computedStyle = getComputedStyle(document.body, null);

        if (document.body.style.overflow != "hidden")
        {
        	document.body.style.overflow = "hidden";
        } else {
        	document.body.style.overflow = "visible";
        }
        $("#navigation-dropdown i").toggleClass('fa-bars').toggleClass('fa-close');
       
    });
});