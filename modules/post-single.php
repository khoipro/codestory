<?php
if( have_posts() ) :
while( have_posts() ) : the_post();
	global $post;
	$post_tags = get_the_tags($post->ID);
	?>

	<article class="post-single">
		<header class="post-single__header">
			<h1 class="post-single__title"><?php the_title(); ?></h1>
			<?php
			if( is_single() ) :
				get_template_part('modules/post-meta');
			endif;
			?>
		</header>
		<div class="post-single__content">
			<?php the_content(); ?>
		</div>
		<?php if( !empty($post_tags) ) : ?>
			<div class="post-single__tags">
				<p class="text-uppercase text-bold mb-1 post-single__tag-title"><?php _e('Tags:', 'codestory'); ?></p>
				<?php foreach($post_tags as $tag) : ?>
					<a class="chip" href="<?php echo get_tag_link($tag); ?>"><?php echo $tag->name; ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php if( is_single() ) : ?>
			<footer class="post-single__footer">
				<?php get_template_part('modules/author-box'); ?>
			</footer>
			<?php get_template_part('modules/post-navigation');
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		endif; ?>
	</article>
	<?php
endwhile;
endif;
?>
