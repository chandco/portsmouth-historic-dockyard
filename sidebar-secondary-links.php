<?php /*

For things like sub pages that are not on the top level, or for things that lead onto other content.  But because this is a widget area, these things are going to linger.

Each widget is a smart column.


*/				?>

					<?php if ( is_active_sidebar( 'secondary-links' ) ) : ?>
					<div class='cf-columns secondary-links max-central'>
						<?php dynamic_sidebar( 'secondary-links' ); ?>
					</div>
					<?php else : ?>

						<?php
							/*
							 * This content shows up if there are no widgets defined in the backend.
							*/
						?>

						<div class="no-widgets">
							<p><?php _e( 'This is loaded from sidebar-secondary-links.php', 'cf-theme' );  ?></p>
						</div>

					<?php endif; ?>

				
				