<?php

/* 
	Add here any deregistration of scripts and styles by plugins.
	Make sure that you add their functionality or stylings in theme stylesheets or scripts, or suffer the consequences..

	..We have two paths with this theme.

	Option 1)
		This is a bespoke theme, not some fits all thing to give to people who want to add random plugins.

		This means that if a plugin breaks things, we don't care - we are controlling plugins and thus their scripts. 

		The result of this is elegant JavaScript with Require.JS


	Option 2)
		This theme may be ported around, and given to people that rely on plugins to add functionality.  That's not something I want to support much

		But it's fair enough, and then Require.JS might not be useful, and oldskool method of wp_enqueue is the way forward.


	As this repo gets forked you'll probably want to delete this rambling and make a definition about which option it went.

*/


/*

WE ARE DEREGISTERING CF7 JAVASCRIPT!  Make sure you add it with require.js

if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
	wpcf7_enqueue_scripts();
}*/

 add_filter( 'wpcf7_load_js', '__return_false' );

add_filter( 'wpcf7_load_css', '__return_false' );


function cf_deregister_plugin_scripts() {


	

}

// get rid of yarp CSS
add_action('wp_print_styles','lm_dequeue_header_styles');
function lm_dequeue_header_styles()
{
  wp_dequeue_style('yarppWidgetCss');
  wp_dequeue_style('yarppRelatedCss');

}

add_action('get_footer','lm_dequeue_footer_styles');
function lm_dequeue_footer_styles()
{
  wp_dequeue_style('yarppRelatedCss');
  wp_dequeue_style('yarppWidgetCss');
}




add_action( 'wp_print_scripts', 'cf_deregister_plugin_scripts', 100 );



