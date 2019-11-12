<?php
if ( post_password_required() ) {
	return;
}

$discussion = codestory_get_discussion_data();
?>
<div id="comments" class="panel <?php echo comments_open() ? 'comments-area' : 'comments-area comments-closed'; ?> <?php echo $discussion->responses > 0 ? 'comments-title-wrap' : 'comments-title-wrap no-responses'; ?>">
	<div class="panel-header">
		<h2 class="panel-title h4">
			<?php
			if ( comments_open() ) {
				if ( have_comments() ) {
					_e( 'Join the Conversation', 'codestory' );
				} else {
					_e( 'Leave a comment', 'codestory' );
				}
			} else {
				if ( '1' == $discussion->responses ) {
					/* translators: %s: post title */
					printf( _x( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'codestory' ), get_the_title() );
				} else {
					printf(
					/* translators: 1: number of comments, 2: post title */
						_nx(
							'%1$s reply on &ldquo;%2$s&rdquo;',
							'%1$s replies on &ldquo;%2$s&rdquo;',
							$discussion->responses,
							'comments title',
							'codestory'
						),
						number_format_i18n( $discussion->responses ),
						get_the_title()
					);
				}
			}
			?>
		</h2>
	</div>
	<div class="panel-body">
	<?php
	if ( have_comments() ) :
		?>
			<?php
			// Show comment form at top if showing newest comments at the top.
			if ( comments_open() ) {
				codestory_comment_form( 'asc' );
			}
			wp_list_comments(
				array(
					'walker'      => new CodeStory_Walker_Comment(),
					'avatar_size' => 60,
					'short_ping'  => true,
					'style'       => 'div',
				)
			);
			?>

		<?php
		// Show comment navigation
		get_template_part('modules/comment-navigation');

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments">
				<?php _e( 'Comments are closed.', 'codestory' ); ?>
			</p>
		<?php
		endif;
	else :
		// Show comment form.
		codestory_comment_form( 'asc' );
	endif; // if have_comments();
	?>
	</div>
</div>
