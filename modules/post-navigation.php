<?php

ob_start();
$prev_icon     = '<span class="icon icon-arrow-left"></span>';
$next_icon     = '<span class="icon icon-arrow-right"></span>';
the_post_navigation(
	array(
		'next_text' => '<span class="text-gray meta-nav">' . __( 'Next Post', 'codestory' ) . $next_icon . '</span> ' .
		               '<span class="screen-reader-text">' . __( 'Next post:', 'codestory' ) . '</span> <br/>' .
		               '<span class="h5 post-title">%title</span>',
		'prev_text' => '<span class="text-gray meta-nav">' . $prev_icon . __( 'Previous Post', 'codestory' ) . '</span> ' .
		               '<span class="screen-reader-text">' . __( 'Previous post:', 'codestory' ) . '</span> <br/>' .
		               '<span class="h5 post-title">%title</span>',
	)
);
$post_pagination = ob_get_contents();
ob_clean();
ob_end_flush();

$post_pagination = str_replace('nav-links', 'columns', $post_pagination);
$post_pagination = str_replace('nav-previous', 'column col-6 col-xs-12 mt-2', $post_pagination);
$post_pagination = str_replace('nav-next', 'column col-6 col-xs-12 mt-2', $post_pagination);

?>
<div class="post-navigation-wrapper">
	<?php echo $post_pagination; ?>
</div>
