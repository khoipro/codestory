<?php
global $wp_query;
?>
<main class="main">
	<?php
	if( !is_front_page() ) :
		get_template_part('modules/breadcrumbs');
	endif;
	?>
	<div class="container">
		<div class="columns">
			<div class="column col-8 col-lg-8 col-md-12">
				<?php
				if( !is_single() && !is_page() ) :
					if (is_category() ) :
						$category_description = category_description();
						?>
						<header class="hero hero--archive">
							<div class="hero-body">
								<h1 class="h2 mb-2"><?php _e('Category: ', 'codestory') . single_cat_title(''); ?></h1>
								<?php if( !empty($category_description) ) : ?>
									<div class="text-gray"><?php echo $category_description; ?></div>
								<?php endif; ?>
							</div>
						</header>
					<?php
					elseif( is_search() ) : ?>
						<header class="hero hero--archive">
							<div class="hero-body">
								<h1 class="h2 mb-2"><?php printf( __('Search results for: <span class="%1$s">%2$ss</span>', 'codestory'), 'text-bold', get_search_query()); ?></h1>
							</div>
						</header>
					<?php elseif( is_author() ) :

						get_template_part('modules/author-box');

					elseif( is_archive() ) : ?>
						<header class="hero hero--archive">
							<div class="hero-body">
								<?php the_archive_title( '<h1 class="h2">', '</h1>' ); ?>
							</div>
						</header>
					<?php endif;

					get_template_part('modules/post-list');

					if ($wp_query->max_num_pages > 1) :
						get_template_part('modules/pagination');
					endif;

				else :
					get_template_part('modules/post-single');
				endif;
				?>
			</div>
			<div class="column col-4 col-lg-4 col-md-12">
				<?php get_template_part('modules/sidebar'); ?>
			</div>
		</div>
	</div>
</main>
