<section class="post-list">
	<?php while( have_posts() ) : the_post(); ?>
		<article class="post-card mt-2">
			<header class="post-card__header">
				<h3 class="post-card__title">
					<a class="post-card__title-link h3" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
				<?php get_template_part('modules/post-meta'); ?>
			</header>
			<p class="post-card__meta"></p>
			<div class="post-card__content">
				<?php the_excerpt(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</section>
