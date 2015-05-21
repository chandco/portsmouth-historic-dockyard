<?php
/*
 Template Name: Home Page
 *
 * Home Page template
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>
<div class='responsive-flex-container'>

	<div id="home-left-sidebar" class='left-sidebar'>
		<?php if ( is_active_sidebar( 'home-sidebar' ) ) : ?>

			<?php dynamic_sidebar( 'home-sidebar' ); ?>

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

	<div id="weekly-menu-table" class='right-content'>
		<?php if ( have_posts() ) : while( have_posts() ) : the_post();
	     the_content();
		endwhile; endif; ?>
	</div>

	<div id="footer-sidebar" class='full-width'>
		<h2>Latest Posts</h2>
		<?php
			
				$args = array(
					
					
					'posts_per_page'         => 4,
					// maybe add tax queries here
					
				);

				
			
			$latest = new WP_Query( $args );


			if ( $latest->have_posts() ) {
				echo "<ul class='grid-feed'>";
				while ($latest->have_posts() ) {
					$latest->the_post();

					get_template_part( 'content/post-preview' );

				}

				echo "</ul>";
			}

			wp_reset_postdata();


		?>
	</div>

</div>


<?php get_footer(); ?>
