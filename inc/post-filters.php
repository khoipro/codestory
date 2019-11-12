<?php

function codestory_new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'codestory_new_excerpt_more');
