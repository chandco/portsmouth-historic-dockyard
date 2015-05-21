<li class='post-preview'>
	<a href='<?php the_permalink(); ?>'>
		<div class='image-container'>
			<?php
			if (has_post_thumbnail()) {
				echo responsive_image_thumbnail(null, 'thumbnail');
			}
			?>
		</div>	

		<h4><?php the_title(); ?></h4>
	</a>
	
	<div class='excerpt'>
		<?php the_excerpt(); ?>
	</div>
</li>