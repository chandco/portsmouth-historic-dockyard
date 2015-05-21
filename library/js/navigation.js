
define(['jquery'], function($) { 

$menu = $("#inner-footer nav").clone();
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



