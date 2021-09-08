<?php
/**
 * Custom template tags for this theme
 *
 * @package Ayin
 * @since 1.0.0
 */

if ( ! function_exists( 'ayin_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function ayin_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		printf(
			'<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
			ayin_get_icon_svg( 'calendar', 16 ),
			esc_url( get_permalink() ),
			$time_string
		);
	}
endif;

if ( ! function_exists( 'ayin_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function ayin_posted_by() {
		printf(
			/* translators: 1: SVG icon. 2: post author, only visible to screen readers. 3: author link. */
			'<span class="byline">%1$s<span class="screen-reader-text">%2$s</span><span class="author vcard"><a class="url fn n" href="%3$s">%4$s</a></span></span>',
			ayin_get_icon_svg( 'person', 16 ),
			__( 'Posted by', 'ayin' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'ayin_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function ayin_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			echo ayin_get_icon_svg( 'comment', 16 );

			/* translators: %s: Name of current post. Only visible to screen readers. */
			comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'ayin' ), get_the_title() ) );

			echo '</span>';
		}
	}
endif;

if ( ! function_exists( 'ayin_entry_meta_header' ) ) :
	/**
	 * Allow child themes to include meta in the header of the post
	 * by overwriting this function.
	 */
	function ayin_entry_meta_header() {
		/* translators: used between list items, there is a space after the comma. */
		$categories_list = get_the_category_list( __( ', ', 'ayin' ) );
		if ( $categories_list ) {
			printf(
				/* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of categories. */
				'<span class="cat-links"><span class="screen-reader-text">%1$s</span>%2$s</span>',
				__( 'Posted in', 'ayin' ),
				$categories_list
			); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma. */
		$tags_list = get_the_tag_list( '', __( ', ', 'ayin' ) );
		if ( $tags_list ) {
			printf(
				/* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of tags. */
				'<span class="tags-links"><span class="screen-reader-text">%1$s</span>%2$s</span>',
				__( 'Tags:', 'ayin' ),
				$tags_list
			); // WPCS: XSS OK.
		}

		echo do_shortcode("[ayin_print_button]");
	}
endif;

if ( ! function_exists( 'ayin_entry_meta_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ayin_entry_meta_footer() {

	}
endif;

if ( ! function_exists( 'ayin_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function ayin_post_thumbnail() {
		if ( ! ayin_can_show_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<figure class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</figure><!-- .post-thumbnail -->

			<?php
		else :
			?>

			<figure class="post-thumbnail">
				<a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail( 'post-thumbnail' ); ?>
				</a>
			</figure>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'ayin_comment_avatar' ) ) :
	/**
	 * Returns the HTML markup to generate a user avatar.
	 */
	function ayin_get_user_avatar_markup( $id_or_email = null ) {

		if ( ! isset( $id_or_email ) ) {
			$id_or_email = get_current_user_id();
		}

		return sprintf( '<div class="comment-user-avatar comment-author vcard">%s</div>', get_avatar( $id_or_email, ayin_get_avatar_size() ) );
	}
endif;

if ( ! function_exists( 'ayin_the_post_navigation' ) ) :
	/**
	 * Documentation for function.
	 */
	function ayin_the_post_navigation() {
		if ( is_singular( 'attachment' ) ) {
			// Parent post navigation.
			the_post_navigation(
				array(
					/* translators: %s: parent post link */
					'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'ayin' ), '%title' ),
				)
			);
		} elseif ( is_singular( 'post' ) ) {
			// Previous/next post navigation.
			the_post_navigation(
				array(
					// 'taxonomy'                   => __( 'post_category' ),
					'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Work', 'ayin' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Next post:', 'ayin' ) . '</span> <br/>' .
						'<span class="post-title">%title</span>',
					'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Work', 'ayin' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Previous post:', 'ayin' ) . '</span> <br/>' .
						'<span class="post-title">%title</span>',
					'in_same_term' => true
				)
			);
		}
	}
endif;

if ( ! function_exists( 'ayin_the_posts_pagination' ) ) :
	/**
	 * Documentation for function.
	 */
	function ayin_the_posts_pagination() {
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					ayin_get_icon_svg( 'chevron_left', 22 ),
					__( 'Newer posts', 'ayin' )
				),
				'next_text' => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					__( 'Older posts', 'ayin' ),
					ayin_get_icon_svg( 'chevron_right', 22 )
				),
			)
		);
	}
endif;
