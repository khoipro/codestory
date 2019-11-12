<?php
global $wp_query;

$pages = paginate_links( [
		'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
		'format'       => '?paged=%#%',
		'current'      => max( 1, get_query_var( 'paged' ) ),
		'total'        => $wp_query->max_num_pages,
		'type'         => 'array',
		'show_all'     => false,
		'end_size'     => 3,
		'mid_size'     => 1,
		'prev_next'    => true,
		'prev_text'    => __( '« Prev' ),
		'next_text'    => __( 'Next »' ),
		'add_args'     => false,
		'add_fragment' => ''
	]
);
if ( !empty($pages) ) : ?>
	<div class="text-center pagination-wrapper">
		<ul class="pagination">
			<?php foreach($pages as $page) :
				$is_page_active = strpos($page, 'current') !== false;
				$page_name = str_replace('page-numbers', 'page-link', $page);
				?>
				<li class="page-item<?php if( $is_page_active ) : ?> active<?php endif; ?>"><?php echo $page_name; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif;
