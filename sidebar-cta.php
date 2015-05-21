				

					<?php if ( is_active_sidebar( 'cta-sidebar' ) ) : ?>

						<?php dynamic_sidebar( 'cta-sidebar' ); ?>

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

				
				