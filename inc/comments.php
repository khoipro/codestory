<?php

class CodeStory_Widget_Recent_Comments extends WP_Widget {
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_codestory_recent_comments',
			'description'                 => __( 'Display recent comments in CodeStory\'s theme', 'codestory' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'codestory-recent-comments', sprintf(__( '[%s] Recent Comments', 'codestory'), wp_get_theme()->get('Name')), $widget_ops );
	}

	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$output = '';

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Comments' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}

		$comments = get_comments(
			apply_filters(
				'widget_comments_args',
				array(
					'number'      => $number,
					'status'      => 'approve',
					'post_status' => 'publish',
				),
				$instance
			)
		);

		$output .= $args['before_widget'];
		if ( $title ) {
			$output .= '<div class="panel-header"><div class="panel-title">' . $args['before_title'] . $title . $args['after_title'] . '</div></div>';
		}

		$output .= '<div class="panel-body">';
		if ( is_array( $comments ) && $comments ) {
			// Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
			$post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
			_prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

			foreach ( (array) $comments as $comment ) {
				$comment_avatar = get_avatar($comment->comment_author_email, 40);
				$comment_content = wp_trim_words(esc_html__($comment->comment_content), 15, '...');
				$output .= '<div class="mb-2 tile">';
				if (!empty($comment_avatar) ) {
					$output .= '<div class="tile-icon"><figure class="avatar">';
						$output .= $comment_avatar;
					$output .= '</figure></div>';
				}
				$output .= '<div class="tile-content">';
					$output .= '<p class="mb-1 tile-title"><span class="text-bold">' . $comment->comment_author . '</span> ' . __('on', 'codestory') . ' <a class="text-primary" href="' . esc_url( get_comment_link( $comment ) ) . '">' . get_the_title($comment->comment_post_ID) . '</a></p>';
					$output .= '<blockquote class="mb-0 tile-subtitle">';
						$output .= $comment_content;
					$output .= '</blockquote>';
				$output .= '</div>';
				$output .= '</div>';
			}
		}
		$output .= '</div>';
		$output .= $args['after_widget'];

		echo $output;
	}

	public function update( $new_instance, $old_instance ) {
		$instance           = $old_instance;
		$instance['title']  = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = absint( $new_instance['number'] );
		return $instance;
	}

	public function form( $instance ) {
		$title  = isset( $instance['title'] ) ? $instance['title'] : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'codestory' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of comments to show:', 'codestory' ); ?></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>
		<?php
	}
}

function codestory_recent_comments_widget_init() {
	register_widget('CodeStory_Widget_Recent_Comments');
}
add_action('widgets_init', 'codestory_recent_comments_widget_init');

class CodeStory_Walker_Comment extends Walker_Comment {

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		$avatar = get_avatar( $comment, $args['avatar_size'] );

		?>
		<div id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'fw tile comment-item--has-parent' : 'fw tile comment-item', $comment ); ?>>
		<div class="tile-icon">
			<figure class="avatar"><?php echo $avatar; ?></figure>
		</div>
		<div class="tile-content">
			<div class="tile-title">
				<div class="vcard">
					<?php
					$comment_author_url = get_comment_author_url( $comment );
					$comment_author     = get_comment_author( $comment );

					printf(
					/* translators: %s: comment author link */
						wp_kses(
							__( '%s <span class="screen-reader-text says">says:</span>', 'codestory' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						'<strong class="text-bold fn">' . $comment_author . '</strong>'
					);

					if ( ! empty( $comment_author_url ) ) {
						echo '</a>';
					}
					?>
				</div><!-- .comment-author -->

				<div class="tile-subtitle">
					<small>
						<?php
						/* translators: 1: comment date, 2: comment time */
						$comment_timestamp = sprintf( __( '%1$s at %2$s', 'codestory' ), get_comment_date( '', $comment ), get_comment_time() );
						?>
						<time class="text-gray" datetime="<?php comment_time( 'c' ); ?>" title="<?php echo $comment_timestamp; ?>">
							<?php echo $comment_timestamp; ?>
						</time>
					</small>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="title-subtitle text-primary comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'codetot' ); ?></p>
				<?php endif; ?>
			</div>
			<div class="tile-subtitle">
				<?php
				comment_text();
				?>
			</div>
		</div>

		<?php
		ob_start();
		comment_reply_link(
			array_merge(
				$args,
				array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="comment-reply">',
					'after'     => '</div>',
				)
			)
		);
		$reply_link = ob_get_contents();
		$reply_link = str_replace('comment-reply-link', 'btn btn-secondary', $reply_link);
		ob_clean();
		ob_end_flush();

		echo $reply_link;
	}
}

function codestory_comment_fields($fields) {
	$commenter = wp_get_current_commenter();
	$consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

	$fields['author'] = '<div class="form-group"><label class="form-label" for="author">' . __('Full Name', 'codestory') . '</label><input class="form-input" type="text" id="author" name="author" value="' . esc_attr( $commenter['comment_author'] ) . '"></div>';
	$fields['email'] = '<div class="form-group"><label class="form-label" for="email">' . __('Email', 'codestory') . '</label><input class="form-input" type="text" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,14}$" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"></div>';
	$fields['url'] = '<div class="form-group"><label class="form-label" for="url">' . __('Website URL', 'codestory') . '</label><input class="form-input" type="url" id="url" name="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '"></div>';
	$fields['cookies'] = '<div class="form-group"><label class="form-checkbox" for="wp-comment-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . '><i class="form-icon"></i> ' . __( 'Save my name, email, and website in this browser for the next time I comment.', 'codestory' ) . '</label></div>';
	return $fields;
}
add_filter('comment_form_default_fields', 'codestory_comment_fields');

if ( ! function_exists( 'codestory_comment_form' ) ) :
	/**
	 * Documentation for function.
	 */
	function codestory_comment_form( $order ) {
		if ( true === $order || strtolower( $order ) === strtolower( get_option( 'comment_order', 'asc' ) ) ) {

			global $current_user;
			$user_identity = $current_user->display_name;

			comment_form(
				array(
					'title_reply'  => null,
					'class_submit' => 'btn btn-primary',
					'must_log_in' => '<p class="tile-subtitle mt-0 mb-2 must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'codestory' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
					'logged_in_as' => '<p class="tile-subtitle logged-in-as">' . sprintf( __( 'Logged in as <a class="text-bold" href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
					'comment_field' => '<div class="form-group"><label class="form-label" for="url">' . __('Comment', 'codestory') . '</label><textarea class="form-input" id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea></div>',
					'comment_notes_after' => '<p class="tile-subtitle form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'codestory' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>'
				)
			);
		}
	}
endif;

function codestory_get_discussion_data() {
	static $discussion, $post_id;

	$current_post_id = get_the_ID();
	if ( $current_post_id === $post_id ) {
		return $discussion; /* If we have discussion information for post ID, return cached object */
	} else {
		$post_id = $current_post_id;
	}

	$comments = get_comments(
		array(
			'post_id' => $current_post_id,
			'orderby' => 'comment_date_gmt',
			'order'   => get_option( 'comment_order', 'asc' ), /* Respect comment order from Settings » Discussion. */
			'status'  => 'approve',
			'number'  => 20, /* Only retrieve the last 20 comments, as the end goal is just 6 unique authors */
		)
	);

	$authors = array();
	foreach ( $comments as $comment ) {
		$authors[] = ( (int) $comment->user_id > 0 ) ? (int) $comment->user_id : $comment->comment_author_email;
	}

	$authors    = array_unique( $authors );
	$discussion = (object) array(
		'authors'   => array_slice( $authors, 0, 6 ),           /* Six unique authors commenting on the post. */
		'responses' => get_comments_number( $current_post_id ), /* Number of responses. */
	);

	return $discussion;
}

function codestory_is_comment_by_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}
