<?php get_header(); ?>

<?php // main blog feed ?>
			<div id="content">

				<div id="inner-content" class="wrap cf" class='responsive-flex-container'>

						<div id="main" class="m-all t-2of3 d-5of7 cf left-content" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php 
								get_template_part( 'post-formats/format-archive', get_post_format() );
							?>

							<?php endwhile; ?>

									<?php bones_page_navi(); ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'cf-theme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'cf-theme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the index.php template.', 'cf-theme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>


						</div>

					<?php get_sidebar(); ?>

				</div>

			</div>


<?php get_footer(); ?>
