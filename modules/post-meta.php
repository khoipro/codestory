<?php
global $post;
$author_id = $post->post_author;
$author_name = get_the_author_meta('display_name', $author_id);
$author_avatar_url = get_avatar_url($author_id);
$categories = get_the_category($post);
$first_category = $categories[0];
$first_category_url = get_category_link($first_category);
?>
<div class="f fw aic post-meta">
	<?php if( !empty($author_name) && !empty($author_avatar_url) ) : ?>
		<div class="f aic post-meta__author">
			<figure class="avatar avatar-lg no-bg post-meta__avatar-wrapper">
				<img src="<?php echo $author_avatar_url; ?>" alt="<?php echo $author_name; ?>">
			</figure>
			<a class="text-dark ml-2" href="#author"><?php echo $author_name; ?></a>
		</div>
	<?php endif; ?>
	<?php if( !empty($first_category_url) ) : ?>
		<p class="mb-0 post-meta__category">
			<a class="d-block post-meta__category-link" href="<?php echo $first_category_url; ?>">
				<span class="icon icon-link"></span>
				<?php echo $first_category->name; ?>
			</a>
		</p>
	<?php endif; ?>
	<?php codestory_posted_on(); ?>
</div>
