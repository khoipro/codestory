<aside class="sidebar">
	<div class="sidebar__inner">
		<?php if ( is_active_sidebar( 'main-sidebar' ) ) : ?>
			<?php dynamic_sidebar( 'main-sidebar' ); ?>
		<?php else : ?>
			<!-- Time to add some widgets! -->
		<?php endif; ?>
	</div>
</aside>
