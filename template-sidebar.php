<?php
/*
 Template Name: Page with Sidebar
 *
 * Home Page template
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>


<div class='responsive-flex-container'>

	
	<div class='left-content'>
		<?php get_template_part( 'content/page' ); ?>
	</div>


	<div class='right-sidebar'>
		<?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>

				<?php dynamic_sidebar( 'blog-sidebar' ); ?>

					<?php else : ?>

					<?php
						/*
						 * This content shows up if there are no widgets defined in the backend.
						*/
					?>

					<div class="no-widgets">
						<p><?php _e( 'This is a widget ready area. Add some and they will appear here.', 'cf-theme' );  ?></p>
					</div>

		<?php endif; ?>
	</div>

</div>


<?php get_footer(); ?>
