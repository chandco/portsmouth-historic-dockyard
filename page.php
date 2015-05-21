<?php
/*
 Template Name: Attached Images Carousel
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>


							<?php // LOGIC FOR FEATURE IMAGE / CAROUSEL / NONE //echo do_shortcode('[images_carousel fill="true"]' );
							
							$terms = get_the_terms( get_the_id(), 'media-tags' );

							if ($terms && count($terms) > 0) { // we have a media tag attached.  That means they want a carousel - get the images for that


								$term_array = array();

								foreach ($terms as $term) {
									$term_array[] = $term->slug;								
								}
								$atts = 
								array(
									'tag' => implode(',', $term_array),
									'fill' => true
								);

								?>
								<div id="carousel" class='carousel'>

								<?php echo display_attached_images_carousel($atts); ?>

								</div>

							<?php } elseif ( has_post_thumbnail() ) { // featured image ?>
														
							
								<div id="carousel" class='featured-image cycle-slideshow'>

									<?php echo responsive_image_thumbnail(null, 'panorama'); ?>

								</div>
							<?php } ?>


			<div id="content">

				<div id="inner-content" class="wrap cf">

						

						<?php get_template_part( 'content/page' ); ?>

						<?php // get_sidebar(); ?>

				</div>

				

			</div>



<?php get_footer(); ?>
