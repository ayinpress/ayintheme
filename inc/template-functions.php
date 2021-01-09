<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Ayin
 * @since 1.0.0
 */

/**
 * Remove Gutenberg `Theme` Block Styles
 */
function ayin_deregister_styles() {
	wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_print_styles', 'ayin_deregister_styles', 100 );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ayin_body_classes( $classes ) {

	if ( is_singular() ) {
		// Adds `singular` to singular pages.
		$classes[] = 'singular';
	} else {
		// Adds `hfeed` to non singular pages.
		$classes[] = 'hfeed';
	}

	// Add a body class if main navigation is active.
	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'has-main-navigation';
	}

	return $classes;
}
add_filter( 'body_class', 'ayin_body_classes' );

/**
 * Adds custom class to the array of posts classes.
 */
function ayin_post_classes( $classes, $class, $post_id ) {
	$classes[] = 'entry';

	return $classes;
}
add_filter( 'post_class', 'ayin_post_classes', 10, 3 );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ayin_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'ayin_pingback_header' );

/**
 * Changes comment form default fields.
 */
function ayin_comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'ayin_comment_form_defaults' );

/**
 * Filters the default archive titles.
 */
function ayin_get_the_archive_title( $title, $original_title, $prefix ) {
	if ( is_category() ) {
		$prefix = '<span class="archive-prefix">' . __( 'Category Archives: ', 'ayin' ) . '</span>';
		$title  = '<span class="page-description">' . single_term_title( '', false ) . '</span>';
	} elseif ( is_tag() ) {
		$prefix = '<span class="archive-prefix">' . __( 'Tag Archives: ', 'ayin' ) . ' </span>';
		$title  = '<span class="page-description">' . single_term_title( '', false ) . '</span>';
	} elseif ( is_author() ) {
		$prefix = '<span class="archive-prefix">' . __( 'Author Archives: ', 'ayin' ) . ' </span>';
		$title  = '<span class="page-description">' . get_the_author_meta( 'display_name' ) . '</span>';
	} elseif ( is_year() ) {
		$prefix = '<span class="archive-prefix">' . __( 'Yearly Archives: ', 'ayin' ) . ' </span>';
		$title  = '<span class="page-description">' . get_the_date( _x( 'Y', 'yearly archives date format', 'ayin' ) ) . '</span>';
	} elseif ( is_month() ) {
		$prefix = '<span class="archive-prefix">' . __( 'Monthly Archives: ', 'ayin' ) . ' </span>';
		$title  = '<span class="page-description">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'ayin' ) ) . '</span>';
	} elseif ( is_day() ) {
		$prefix = '<span class="archive-prefix">' . __( 'Daily Archives: ', 'ayin' ) . ' </span>';
		$title  = '<span class="page-description">' . get_the_date() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$prefix = '';
		$cpt    = get_post_type_object( get_queried_object()->name );
		/* translators: %s: Post type singular name */
		$title = sprintf(
			esc_html__( '%s Archives', 'ayin' ),
			$cpt->labels->singular_name
		);
	} elseif ( is_tax() ) {
		$prefix = '';
		$tax    = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: %s: Taxonomy singular name */
		$title = sprintf(
			esc_html__( '%s Archives', 'ayin' ),
			$tax->labels->singular_name
		);
	} else {
		$prefix = '';
		$title  = '<span class="archive-prefix">' . __( 'Archives: ', 'ayin' ) . ' </span>';
	}

	return '<h1 class="page-title">' . $prefix . $title . '</h1>';
}
add_filter( 'get_the_archive_title', 'ayin_get_the_archive_title', 10, 3 );

/**
 * Determines if post thumbnail can be displayed.
 */
function ayin_can_show_post_thumbnail() {
	return apply_filters( 'ayin_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}

/**
 * Returns the size for avatars used in the theme.
 */
function ayin_get_avatar_size() {
	return 60;
}

/**
 * Returns true if comment is by author of the post.
 *
 * @see get_comment_class()
 */
function ayin_is_comment_by_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}

/**
 * WCAG 2.0 Attributes for Dropdown Menus
 *
 * Adjustments to menu attributes tot support WCAG 2.0 recommendations
 * for flyout and dropdown menus.
 *
 * @ref https://www.w3.org/WAI/tutorials/menus/flyout/
 */
function ayin_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

	// Add [aria-haspopup] and [aria-expanded] to menu items that have children
	$item_has_children = in_array( 'menu-item-has-children', $item->classes );
	if ( $item_has_children ) {
		$atts['aria-haspopup'] = 'true';
		$atts['aria-expanded'] = 'false';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'ayin_nav_menu_link_attributes', 10, 4 );

/*
 * Create the continue reading link
 */
function ayin_continue_reading_link() {

	if ( ! is_admin() ) {
		$continue_reading = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'ayin' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		);

		return '<a class="more-link" href="' . esc_url( get_permalink() ) . '">' . $continue_reading . '</a>';
	}
}

// Filter the excerpt more link
add_filter( 'excerpt_more', 'ayin_continue_reading_link' );

// Filter the content more link
add_filter( 'the_content_more_link', 'ayin_continue_reading_link' );

/**
 * Add a dropdown icon to top-level menu items.
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 * @return string Nav menu item start element.
 * Add a dropdown icon to top-level menu items
 */
function ayin_add_dropdown_icons( $output, $item, $depth, $args ) {

	// Only add class to 'top level' items on the 'primary' menu.
	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $output;
	}

	if ( 'primary' == $args->theme_location && $depth === 0 ) {
		if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {

			// Add SVG icon to parent items.
			$output .= ayin_get_icon_svg( 'dropdown', 24 );
		}
	}

	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'ayin_add_dropdown_icons', 10, 4 );
