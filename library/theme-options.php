<?php

// This page handles custom options pages and the like.  Mostly for registering basic website info like the phone number, facebook etc etc.

// It's up to the theme to make use of these later.




function register_my_setting() {
	//register_setting( 'services_config', 'services_blurb');
	register_setting( 'services_config', 'cf_option_linked_in');
	register_setting( 'services_config', 'cf_option_facebook');
	register_setting( 'services_config', 'cf_option_twitter');
	register_setting( 'services_config', 'cf_option_email');
	register_setting( 'services_config', 'cf_option_phone');	
	register_setting( 'services_config', 'cf_footerinfo');	
}
add_action('admin_init','register_my_setting');
add_action('admin_menu', 'cf_option_admin_menu');
function cf_option_admin_menu() {
	
	add_options_page( 'Website Information', 'Website Information', 'manage_options', 'update_services_blurb_page', 'add_update_services_blurb_output' );
	
}
function add_tiny_and_stuffs($hook)
{
	
	if ($hook != 'settings_page_update_services_blurb_page') return;

	wp_enqueue_script('jquery');
  	wp_enqueue_script('tiny_mce');
}
add_action( 'admin_enqueue_scripts', 'add_tiny_and_stuffs' );


function add_update_services_blurb_output()
{
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	echo '<div class="wrap tmc-settings">';
	?><h2>Website Info</h2>
	<p>Update various information about the website such as the main contact email, phone number, social media links and so on...</p>
	<p>Email and Phone number should NOT be left blank.  Social media options do not need entering if they do not exist</p>
	
	<?php
	echo '<form method="post" action="options.php">';
	settings_fields( 'services_config' );
	do_settings_sections( 'services_config' );
	?>
    
    
    <h3>Contact / Social info</h3>
<style>
	.tmc-settings input {
		width:200px;
	}
	</style>
  	<P><label for='cf_option_linked_in'>Linked In URL</label>
    <input type="text" name="cf_option_linked_in" id="cf_option_linked_in" value="<?php echo get_option('cf_option_linked_in'); ?>" /></P>
    
    <P> <label for='cf_option_facebook'>Facebook URL</label>
    <input type="text" name="cf_option_facebook" id="cf_option_facebook" value="<?php echo get_option('cf_option_facebook'); ?>" /></P>

  	<P><label for='cf_option_twitter'>Twitter URL</label>
    <input type="text" name="cf_option_twitter" id="cf_option_twitter" value="<?php echo get_option('cf_option_twitter'); ?>" /></P>

  	<P><label for='cf_option_email'>Contact Email Address</label>
    <input type="text" name="cf_option_email" id="cf_option_email" value="<?php echo get_option('cf_option_email'); ?>" /></P>

  	<P><label for='cf_option_phone'>Contact Phone Number</label>
    <input type="text" name="cf_option_phone" id="cf_option_phone" value="<?php echo get_option('cf_option_phone'); ?>" /></P>

    <P><label for='cf_footerinfo'>Footer Info (eg copyright info)</label>
    <textarea name="cf_footerinfo" id="cf_footerinfo"><?php echo get_option('cf_footerinfo'); ?></textarea></P>

    <?php
	/*
		register_setting( 'services_config', 'services_blurb');
	register_setting( 'services_config', 'cf_option_linked_in');
	register_setting( 'services_config', 'cf_option_facebook');
	register_setting( 'services_config', 'cf_option_twitter');
	register_setting( 'services_config', 'cf_option_email');
	register_setting( 'services_config', 'cf_option_phone');	
	*/
	//echo '<textarea class="theEditor" id="services_blurb" name="services_blurb">' . get_option('services_blurb') . '</textarea>';
	submit_button();
	echo '</form>';
	echo '</div>';
	?><?php
	
}
