<li id="post-<?php the_ID(); ?>" <?php post_class( 'cf blog-grid-item' ); ?> role="article">
	<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
	  <header>
	    <div class='thumbnail'><?php if ( has_post_thumbnail() ) the_post_thumbnail('medium'); // this is a grid of 2 columsn, not three ?></div>
		<h2><?php the_title(); ?></h2>
	  </header>

	  
	  	<div class='excerpt'>
	    	<?php the_excerpt(); ?>
	  	</div>
  	</a>
</li>
