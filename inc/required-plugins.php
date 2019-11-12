<?php

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'codestory_register_required_plugins' );

function codestory_register_required_plugins() {
	$plugins = array(
		array(
			'name'      => 'Code Prettify',
			'slug'      => 'code-prettify',
			'required'  => false
		),
	);

	$config = array(
		'id'           => 'codestory',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => ''
	);

	tgmpa( $plugins, $config );
}
