<?php

/**
 * Theme Support
 */
if ( ! function_exists( 'codestory_setup' ) ) :
    function codestory_setup() {
		add_theme_support( 'title-tag' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 190,
				'width'       => 190,
				'flex-width'  => false,
				'flex-height' => false,
			)
		);

		register_nav_menus( array(
			'header' => __('Header Menu', 'codestory'),
			'sidebar' => __('Sidebar Menu', 'codestory'),
		) );
    }
endif;
add_action( 'after_setup_theme', 'codestory_setup' );

function codetot_scripts() {
	wp_enqueue_style('spectre-css', '//unpkg.com/spectre.css/dist/spectre.min.css', array(), null);
	wp_enqueue_style('spectre-exp-css', '//unpkg.com/spectre.css/dist/spectre-exp.min.css', array(), null);
	wp_enqueue_style('spectre-icons-css', '//unpkg.com/spectre.css/dist/spectre-icons.min.css', array(), null);
	wp_enqueue_style( 'codestory-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_script('codestory-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), wp_get_theme()->get( 'Version' ), true);
}
add_action('wp_enqueue_scripts', 'codetot_scripts');

/**
 * Widgets
 */
function codestory_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Main Sidebar', 'codestory' ),
			'id'            => 'main-sidebar',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'codestory' ),
			'before_widget' => '<div id="%1$s" class="widget widget--sidebar %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="h5 widget__title">',
			'after_title'   => '</p>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Homepage Top Sidebar', 'codestory' ),
			'id'            => 'homepage-top',
			'description'   => __( 'Add widgets here to appear in your Homepage (Top section).', 'codestory' ),
			'before_widget' => '<div class="column f fdc col-md-12"><div id="%1$s" class="f1 widget widget--homepage %2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="h5 widget__title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'codestory_widgets_init' );


