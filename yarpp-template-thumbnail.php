<?php
/*
YARPP Template: Thumbnails
Description: Requires a theme which supports post thumbnails
Author: mitcho (Michael Yoshitaka Erlewine)
*/ ?>

<?php if (have_posts()):?>
<h3>More like this post:</h3>
<ul class='related-posts'>
	<?php while (have_posts()) : the_post(); ?>
		
			<li>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class='title'><?php the_title(); ?></a>
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class='thumbnail'><div class='img'>
						<?php if (has_post_thumbnail()):?>
							<?php the_post_thumbnail('thumbnail'); ?>
						<?php endif; ?>
					</div></a>
				
			</li>
		
	<?php endwhile; ?>
</ul>

<?php else: ?>
<?php endif; ?>
