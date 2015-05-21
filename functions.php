<?php
/*
Author: Nathan Edwards
URL: http://cowfields.co.uk on behalf of http://www.chandco.net

## It's currently 18:40 on a friday night, so I'm crediting myself ##


Based on Bones theme.  I'm modifying it to my own standards

*/

/*** SITE SETUP ***/
# Update these things with whatever you need.  the GA is most important

define('GAPROPERTYID','UA-XXXX-Y');



// BEFORE LOAD CORE 


/** load responsive class 

I'm loading this up top.  Time will tell if this is useful, or if the polyfill is better.  
We should run some tests with and without, because the problem / advantage with the server side method is the images
don't technically "respond" in the browser.  However it's only on a Desktop where the images may 'shrink', and we'll happily
load full res for them and shrink.  With srcset, it could be that you actually slow down desktop experience.

We may want this for other features, so let's load it BEFORE ANYTHING ELSE so that we have a defined value ANYWHERE about what device we're on

/// upload size

**/

if (!strstr($_SERVER["HTTP_HOST"], "dev.chand.co")) {
  require_once("library/minify-html.php");  
}


require_once("library/mobile-detect/Mobile_Detect.php");

$detect = new Mobile_Detect;

define("ISMOBILE", $detect->isMobile());
define("ISTABLET", $detect->isTablet());


//Upload size:
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );


// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

// ADD THEME SETTINGS STUFF
require_once("library/theme-options.php");

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  //Allow editor style.
  add_editor_style();

  // let's get language support going, if you need it
  load_theme_textdomain( 'cf-theme', get_template_directory() . '/library/translation' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  // require_once( 'library/custom-post-type.php' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );


  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // fix gallery markup in wp
  add_filter( 'post_gallery', 'cf_cleaner_gallery', 10, 2 );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in library/sidebars.php
  // Disabled until a theme requires it
  add_action( 'widgets_init', 'cf_register_sidebars' );

  // cleaning up random code around images
  // Remopving this as it's probably screwing with shortcodes.
  // add_filter( 'the_content', 'bones_filter_ptags_on_images' );

  // this may cuase problems with shortocdes.
  


  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );





/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}



// install our must use plugins
require_once("library/install-plugins.php");

/** image based updates - this also includes gallery updates, required within the file below **/
require_once("library/images.php");

/** Column system **/
require_once("library/columns.php");







/************* THEME CUSTOMIZE *********************/

/* 
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
  
  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162
  
  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections 

   $wp_customize->remove_section('title_tagline');
   $wp_customize->remove_section('colors');
   $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');
  
  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

require_once("library/sidebars.php");




/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'cf-theme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'cf-theme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'cf-theme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'cf-theme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/

function bones_fonts() {
  /*
  Add font declarations here
    eg from Gfonts:
      wp_enqueue_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');

  */
}
add_action('wp_enqueue_scripts ', 'bones_fonts');


/* cleanup */
require_once("library/plugin-cleanup.php");

require_once("library/content/carousel.php");

require_once("library/content/shortcodes.php");

require_once("library/editor/editor.php");

add_filter( 'no_texturize_shortcodes', 'shortcodes_to_exempt_from_wptexturize' );
function shortcodes_to_exempt_from_wptexturize($shortcodes){
    $shortcodes[] = 'feature-box';
    $shortcodes[] = 'infobox';
    return $shortcodes;
}




function print_filters_for( $hook = '' ) {
    global $wp_filter;
    if( empty( $hook ) || !isset( $wp_filter[$hook] ) )
        return;

      $hooks = $wp_filter[$hook];
      asort($hooks);
    print '<pre>';

    print_r( $hooks );
    print '</pre>';
}


add_filter('widget_text', 'do_shortcode');