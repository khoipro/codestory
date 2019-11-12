<?php
global $post;
$author_id = $post->post_author;
$author_name = get_the_author_meta('display_name', $author_id);
$author_desc = get_the_author_meta('user_description', $author_id);
$author_url = get_the_author_meta('user_url', $author_id);
$author_archive_url = get_author_posts_url($author_id);
$author_avatar_url = get_avatar_url($author_id);
$author_post_counts = count_user_posts($author_id);

$author_post_query = new WP_Query(array(
	'post_status' => 'publish',
	'author' => $author_id,
	'posts_per_page' => 5
));
?>
<div class="tile author-box<?php if( is_author() ) : ?> author-box--archive<?php endif; ?>" itemtype="http://schema.org/Person" itemscope itemprop="author" id="author">
	<div class="tile-icon">
		<figure class="avatar avatar-xl">
			<img src="<?php echo $author_avatar_url; ?>" alt="<?php echo $author_name; ?>" itemprop="image">
		</figure>
	</div>
	<div class="tile-content">
		<p class="h5 tile-title mb-2" itemprop="name"><?php echo $author_name; ?></p>
		<?php if( !empty($author_desc) ) : ?>
			<p class="tile-subtitle"><?php echo $author_desc; ?></p>
		<?php endif; ?>
		<ul class="menu">
			<li class="divider" data-content="<?php echo strtoupper(__('Social Links &amp; Personal Website', 'codestory')); ?>"></li>
			<?php if( !empty($author_url) ) : ?>
				<li class="menu-item">
					<a href="<?php echo $author_url; ?>" target="_blank" rel="nofollow">www</a>
				</li>
			<?php endif; ?>
			<?php if($author_post_query->have_posts() && !is_author() ) : ?>
				<li class="divider" data-content="<?php echo strtoupper(__('Recent Posts', 'codestory')); ?>"></li>
				<?php while($author_post_query->have_posts() ) : $author_post_query->the_post(); ?>
					<li class="menu-item">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</li>
				<?php endwhile; wp_reset_postdata(); ?>
				<li class="divider"></li>
				<li class="menu-item">
					<a class="btn text-left text-bold" href="<?php echo $author_archive_url; ?>" rel="author" itemprop="url"><?php printf(__('View all posts by %s', 'codestory'), $author_name); ?></a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
</div>
