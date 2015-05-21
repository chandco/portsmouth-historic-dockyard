<?php


// View for featuer box


function views_feature_box() {

	// manual localisation before I find a better way.
    
	?>

	<?php // list the views here ?>
		<script type="text/html" id="tmpl-editor-feature-box">
		<# if ( data.link ) { #>
			<a href="{{ data.link }}" title="{{ data.linktitle }}">
		<# } #>
				<div class='feature'>
					<header>
						<h2>{{ data.title }}</h2>
					</header>
					<# if ( data.innercontent ) { #>
						<div class='content'>{{ data.innercontent }}</div>
					<# } #>
				</div>
		<# if ( data.link ) { #> 
			</a>
		<# } #>
			</script>
	<?php
}


// the shortcode for the front end

function shortcode_feature_box($atts, $content = false) {

	
	$output = "";

	 
	
	 // get some sort of image from img id

	$img = wp_get_attachment_image_src($atts["imgid"], responsive_conditional_size('medium'));

	if ( $content ) { $p_class = "feature has-content"; } else { $p_class = "feature"; }
	$output .= '<div class="' . $p_class . '">';
	if ( $atts["link"] ) {	$output .= '<a href="' . $atts["link"] . '" title="' . $atts["linktitle"] . '">'; } 
	$output .= 	'<header>';
	$output .= 		'<img src="' . $img[0] . '" />';
	$output .= 		'<h2>' . $atts["title"] . '</h2>';
	$output .= 	'</header>';
	if ( $atts["link"]) {	$output .= '</a>'; } 

		 if ( $content ) { 
		 	if ( $atts["link"] ) {	$output .= '<a href="' . $atts["link"] . '" title="' . $atts["linktitle"] . '">'; } 
			$output .= '<div class="content">' . $content . '</div>';
			if ( $atts["link"]) {	$output .= '</a>'; } 
		 } 


	$output .= '</div>';

	 

	
	return $output; 
}



add_shortcode( 'feature-box', 'shortcode_feature_box' );





// Create the ajax page needed
add_action( 'admin_menu', 'mcea_feature_box_init' ); 
function mcea_feature_box_init() {
	add_submenu_page( null, 'Edit Feature Box', 'Edit Feature Box', 'upload_files', 'feature-box-edit', 'feature_box_page' );
}


// The edit popup that appears in an ifram
	function feature_box_page() {

		// we might want to reuse this and use some criteria i.e. hiding things.



		

		//        wp_enqueue_script('wptuts-upload');
		
	

		global $imagesizes;
		$suffix = "-" . get_option('thumbnail_size_w') . "x" . get_option('thumbnail_size_h');
		

		// this needs to be a dynamic style because of how the gallery might change...
		?>

		<style>	

		.uploader img {
			max-width: <?php echo get_option('thumbnail_size_w'); ?>px;
			width: 100%;
			height: auto;
		}

		#wpadminbar, #adminmenuwrap, #adminmenuback {
			display: none;
		}

		.media-modal {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			z-index: 160000;
		}



		</style>


		



		
			<div id="wp-link-backdrop" style="display: none"></div>
		<div id="wp-link-wrap" class="wp-core-ui search-panel-visible" style="display: none">
		<form id="wp-link" tabindex="-1">
		<?php wp_nonce_field( 'internal-linking', '_ajax_linking_nonce', false ); ?>
		<div id="link-modal-title">
			Insert/edit link			<button type="button" id="wp-link-close"><span class="screen-reader-text">Close</span></button>
	 	</div>
		<div id="link-selector">
			<div id="link-options">
				<p class="howto">Enter the destination URL</p>
				<div>
					<label><span>URL</span><input id="url-field" type="text" name="href" /></label>
				</div>
				<div>
					<label><span>Title</span><input id="link-title-field" type="text" name="linktitle" /></label>
				</div>
				<div class="link-target">
					<label><span>&nbsp;</span><input type="checkbox" id="link-target-checkbox" /> Open link in a new window/tab</label>
				</div>
			</div>
			<p class="howto"><a href="#" id="wp-link-search-toggle">Or link to existing content</a></p>
			<div id="search-panel">
				<div class="link-search-wrapper">
					<label>
						<span class="search-label">Search</span>
						<input type="search" id="search-field" class="link-search-field" autocomplete="off" />
						<span class="spinner"></span>
					</label>
				</div>
				<div id="search-results" class="query-results" tabindex="0">
					<ul></ul>
					<div class="river-waiting">
						<span class="spinner"></span>
					</div>
				</div>
				<div id="most-recent-results" class="query-results" tabindex="0">
					<div class="query-notice" id="query-notice-message">
						<em class="query-notice-default">No search term specified. Showing recent items.</em>
						<em class="query-notice-hint screen-reader-text">Search or use up and down arrow keys to select an item.</em>
					</div>
					<ul></ul>
					<div class="river-waiting">
						<span class="spinner"></span>
					</div>
				</div>
			</div>
		</div>
		<div class="submitbox">
			<div id="wp-link-cancel">
				<a class="submitdelete deletion" href="#">Cancel</a>
			</div>
			<div id="wp-link-update">
				<input type="submit" value="Add Link" class="button button-primary" id="wp-link-submit" name="wp-link-submit">
			</div>
		</div>
		</form>
		</div>



		<form id='mce-feature-box-form'>

		<div class='feature-box'>

			<header>
				<div class="img">
					<input id="_unique_name" name="settings[_unique_name]" type="text" />
					<button id='mce-upload' class='button'>Upload New Image</button>
				</div>

				<div class='h2'>
					<label>Title
						<input type='text' name='mce-feature-box' id='mce-feature-box' />
					</label>
				</div>
			
			</header>

			<label>
				Box Text (Optional)
				<textarea id='mce-feature-content'></textarea>
			</label>
		</div>			

		<div class='controls'>
			<label>Turn Feature Box into a link (leave blank if you do not want this to link somewhere):</label><BR>
			<button class='button' id='mce-addlink'>Find Link on Site</button><Br />
			URL:
			<input id="_feature_box_link" name="settings[_feature_box_link]" type="text" value='http://' /><BR />
			Title:
			<input id="_feature_box_title" name="settings[_feature_box_title]" type="text" />
			<hr />
			

			<button id='mce-update' class='button button-primary'>Update</button> <button id='mce-close' class='button'>Close without Updating</button>
		</div>
	</form>
	<script>
		var imgSuffix = "<?php echo $suffix; ?>";
	</script>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/admin/js/views_feature-box.js"></script>
<?php
		 
		   
		       
		 
		   

		 		



	}
//}
//$menu = new mcea();

?>