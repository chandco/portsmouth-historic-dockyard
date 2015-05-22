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

<div class='home-header'>
<?php echo do_shortcode('[images_carousel tag="homepage-carousel" fill="true"]'); ?>

<header class="article-header">

		<h1 class="page-title"><?php the_title(); ?></h1>

</header>

</div>

<div class='responsive-flex-container'>



	<div class='full-width'>
		<?php if ( have_posts() ) : while( have_posts() ) : the_post();
	     the_content();
		endwhile; endif; ?>
	</div>

	<div id="footer-sidebar" class='full-width'>
		<h2>Latest Posts</h2>
		<?php
			
				$args = array(
					
					
					'posts_per_page'  => 4,
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
