<?php

/* this is the start of all the features needed for updating the TinyMCE editor.

	Some parts will be specific to the theme as 
	they'll deal with specifically styled shortcodes 
	but hopefully we can keep their markup and 
	naming generic and only the styles would change

	Shortcodes and their styles:

	1. feature-box // for an image / title / text / link thing.  CSS can change the behaviour
		# TODO LIST:
			# Decide on Markup
			# Form for inputting the data
			# process variables into shortcode atts
			# CSS for components





	2. image-cta // CTA which is an image with a text overlay.  Kinda like feature box without the text and forces a link

	3. CTA button // chunky button, with optional icon

	4. column system.  we should not use views for this due to nesting





*/

add_filter("the_content", "WrapStuff", 0);




function WrapStuff( $post ) {

	$pattern = "/{{section:(\#?.+)}}/";
	

	$chars = preg_split($pattern, $post, null, PREG_SPLIT_DELIM_CAPTURE);
	
	

	$original = $post;

	$newpost = "";
	if (count($chars) == 0) return $post;

	$even = true;


	foreach ($chars as $key => $match) {

		

		if ($even) {
			// content
			$newpost .= $match;

			if ($key > 0) {
				$newpost .= "</section>"; // close div
			}
		} else {

			// flag
			if (substr($match, 0, 1) == '#' || substr(strtolower($match), 0, 3) == 'rgb') {
				$newpost .= "<section class='full-width-background' style='background:" . $match . ";'>"; 
			} else {
				$newpost .= "<section class='full-width-background " . $match . "'>"; 
			}
			
			

		}
		
		
		
		$even = ($even) ? false : true; 
	}

	return $newpost;
	// 	/*
	// 	$match == {{section:colour}}
	// 	$matches[1][$key] == colour
	// 	*/

	// 	echo $x . "<textarea>" . print_r($match, true) . "</textarea>";

		
		
		
	// 	$chunk = strstr($post, $match, TRUE ); // everything before this instance of the section
	// 	echo "<textarea>" . $chunk . "</textarea>";
	// 	echo "<textarea>" . $post . "</textarea>";
	// 	echo "<textarea>" . strstr($post, $match) . "</textarea>";
	// 	$newpost .= $chunk;
		
	// 	if ($key > 0) {
	// 		$newpost .= "</div>";
	// 	}
		
	// 	// open the section
	// 	$newpost .= "<div class='section " . $matches[1][$key] . "'>"; 


		
	// 	echo "<hr>";

	// 	$post = str_replace( $match, "", strstr($post, $match) );
	
	// 	$x++;
		
	// }

	// $newpost .= $post . "</div>"; // we never close this in the loop above

	// return $newpost;



}

function print_filters_for( $hook = '' ) {
    global $wp_filter;
    if( empty( $hook ) || !isset( $wp_filter[$hook] ) )
        return;

    print '<pre>';
    print_r( $wp_filter[$hook] );
    print '</pre>';
}
// not really a shortcode but it is for the editor
// // Callback function to insert 'styleselect' into the $buttons array


//add_filter('mce_buttons_2', 'my_mce_buttons_2');
function my_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter


// Callback function to filter the MCE settings
## This is currently an example, we're not using this yet as we may want to stick with views for now.


function my_mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'Wrapper Div',  
			'block' => 'div',
			'class' => 'cf_columns',
			'wrapper' => true,
		),

		array(  
			'title' => 'Full Width Background Div',  
			'block' => 'div',
			'class' => 'full-width-background',
			'wrapper' => true,
		),


		
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
} 

// stop wordpress from screwing with HTML


add_filter('tiny_mce_before_init','change_mce_options');
function change_mce_options($init){

	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'Wrapper Div',  
			'block' => 'div',
			'class' => 'cf_columns',
			'wrapper' => true,
		),

		array(  
			'title' => 'Full Width Background Div',  
			'block' => 'div',
			'class' => 'full-width-background',
			'wrapper' => true,
		),


		
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init['style_formats'] = json_encode( $style_formats );  
	
    //$init["forced_root_block"] = false;
    $init["force_br_newlines"] = true;
    $init["force_p_newlines"] = false;
    //$init["convert_newlines_to_brs"] = false;
    $opts = '*[*]';
	$init['valid_elements'] = $opts;
	$init['extended_valid_elements'] = '+div.row[div.col-smart]';
	$init['custom_elements'] = 'cfrowblock';
	$init["valid_children"] = "+section[*],+div[*],+span[*]";
	$init["cleanup"] = false;
	$init["verify_html"] = false;
	
    return $init;       
}


add_action( 'init', 'cf_editor_buttons' );
function cf_editor_buttons() {
    add_filter( "mce_external_plugins", "wptuts_add_buttons" );
    add_filter( 'mce_buttons', 'wptuts_register_buttons' );
}




function wptuts_add_buttons( $plugin_array ) {
    $plugin_array['cf_features'] = get_stylesheet_directory_uri() . '/library/editor/admin/js/tinymce.js';
    return $plugin_array;
}

function wptuts_register_buttons( $buttons ) {

	// update this after the javascript is done
    array_push( $buttons, 'feature', 'columns', 'widebg', 'cta-link', 'cta-link-wide', 'addIcons', 'imageStyler', 'venue-gallery' ); //'thirds', 'twothirds-third', 'third-twothirds', 'quarters' ); // dropcap', 'recentposts
    return $buttons;
}




// PHP handling of various ajaxy shortcode stuff:
// setup media library

add_action( 'admin_enqueue_scripts', 'mce_wp_enqueue_media' );
function mce_wp_enqueue_media($hook) {
	

	
	wp_enqueue_style( 'admin-helper-css', get_stylesheet_directory_uri() . '/library/css/admin.css' );
	
	
	

	if ($hook != 'admin_page_' . 'feature-box-edit') return;

    wp_enqueue_script('jquery');
    wp_enqueue_script( 'wplink' );
    wp_enqueue_script('wpdialogs');
    wp_enqueue_script('wpdialogs-popup'); //also might need this

    

	// need these styles
	wp_enqueue_style('wp-jquery-ui-dialog');
	wp_enqueue_style('thickbox');


    wp_enqueue_media();
}


require_once("mce_feature-box.php");






add_action( 'before_wp_tiny_mce', 'custom_before_wp_tiny_mce' );
function custom_before_wp_tiny_mce() {

	global $imagesizes;
	$suffix = "-" . get_option('thumbnail_size_w') . "x" . get_option('thumbnail_size_h');

	?>
	<script type="text/javascript">
    
    

    window.mcedata = { 
    	editorURL: '<?php echo get_stylesheet_directory_uri(); ?>/library/editor/',
    	adminurl : '<?php echo get_admin_url(); ?>',
    	siteurl : '<?php echo get_site_url(); ?>',
    	apiURL : '<?php echo get_site_url("wp-json"); ?>/wp-json/',
    	imgSuffix : '<?php echo $suffix; ?>',
    	};

	</script>


	<?php


	// load all the views here
	views_feature_box(); // [feature-box]
	

	#	[wide_background]

	#	[CTA]

	#	

	#	[carousel]

	#	[columns]


	## LATER ##
	#	CF7

	// Insert normal HTML with classes:

	# Bulleted List with special bullets
	# 


	// etc

}

// ajaxes for tinymce


