<?php
if ( have_comments() ) :
	ob_start();
	$prev_icon     = '<span class="icon icon-arrow-left"></span>';
	$next_icon     = '<span class="icon icon-arrow-right"></span>';
	$comments_text = __( 'Comments', 'codestory' );
	the_comments_navigation(
		array(
			'prev_text' => sprintf( '%s <span class="nav-prev-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', $prev_icon, __( 'Previous', 'codestory' ), __( 'Comments', 'codestory' ) ),
			'next_text' => sprintf( '<span class="nav-next-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span> %s', __( 'Next', 'codestory' ), __( 'Comments', 'codestory' ), $next_icon ),
		)
	);

	$comment_navigation = ob_get_contents();
	ob_clean();
	ob_get_flush();

	$comment_navigation = str_replace('nav-links', 'columns', $comment_navigation);
	$comment_navigation = str_replace('nav-previous', 'column col-6 col-xs-12', $comment_navigation);
	$comment_navigation = str_replace('nav-next', 'column col-6 col-xs-12', $comment_navigation);

	echo $comment_navigation;
endif;
