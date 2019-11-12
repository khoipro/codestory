<?php

if (!is_front_page()) {

	// Start the breadcrumb with a link to your homepage
	echo '<div class="container"><div class="breadcrumb">';
	echo '<li class="breadcrumb-item">';
	echo '<a href="';
	echo get_option('home');
	echo '">';
	bloginfo('name');
	echo '</a>';
	echo '</li>';
	// Check if the current page is a category, an archive or a single page. If so show the category or archive name.
	echo '<li class="breadcrumb-item">';
	if (is_category() || is_single() ) {
		_e('Category: ', 'codestory') . the_category('title_li=');
	} elseif (is_archive() || is_single()) {
		if ( is_day() ) {
			printf( __( '%s', 'codestory' ), get_the_date() );
		} elseif ( is_month() ) {
			printf( __( '%s', 'codestory' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'codestory' ) ) );
		} elseif ( is_year() ) {
			printf(__('%s', 'codestory'), get_the_date(_x('Y', 'yearly archives date format', 'codestory')));
		} elseif( is_author() ) {
			$author_id = get_queried_object_id();
			printf( __( 'Author: %s', 'codestory' ), get_the_author_meta( 'display_name', $author_id ) );
		} else {
			_e( 'Blog Archives', 'codestory' );
		}
	} elseif( is_search() ) {
		printf( __( 'Search results for: <span class="%1$s">%2$ss</span>', 'codestory' ), 'text-bold', get_search_query() );
	} elseif( is_page() || is_single() ) {
		echo the_title();
	} elseif( is_home() ) {
		_e( 'Blog Archives', 'codestory' );
	}
	echo '</li>';
	echo '</div></div>';
}
?>
