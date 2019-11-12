<?php
$custom_logo_id = get_theme_mod('custom_logo');
$logo = wp_get_attachment_image_src($custom_logo_id , 'full');
?>
<header id="masthead" class="navbar-wrapper">
	<div class="container">
		<div class="navbar navbar--left-alignment">
			<?php if ( has_custom_logo() && !empty($logo) ) : ?>
				<div class="navbar-section">
					<?php if (is_front_page() && get_query_var('paged') == 0) : ?>
						<img class="navbar-logo" src="<?php echo esc_url($logo[0]); ?>" alt="<?php bloginfo('name'); ?>">
					<?php else : ?>
						<a class="f aic jcc navbar-logo-link" href="<?php echo esc_url( home_url('/') ); ?>">
							<img class="navbar-logo" src="<?php echo esc_url($logo[0]); ?>" alt="<?php bloginfo('name'); ?>">
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php if( has_nav_menu('header') ) : ?>
				<div class="navbar-section">
					<?php
					$menu_name = 'header';

					if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
						$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
						$menu_items = wp_get_nav_menu_items($menu->term_id);
						foreach ( $menu_items as $key => $menu_item ) {
							$title = $menu_item->title;
							$url = $menu_item->url;
							$menu_list .= '<a class="btn btn-link" href="' . $url . '">' . $title . '</a>';
						}
					}

					echo $menu_list;
					?>
				</div>
			<?php endif; ?>
			<div class="navbar-section">
				<!-- Icon: Search -->
				<button class="btn btn-link btn-action js-toggle-search">
					<span class="icon icon-search navbar-icon"></span>
				</button>
			</div>
		</div>
	</div>
</header>
