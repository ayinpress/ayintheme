<?php
/**
 * SVG icons related functions
 *
 * @package Ayin
 * @since 1.0.0
 */

/**
 * Gets the SVG code for a given icon.
 */
function ayin_get_icon_svg( $icon, $size = 24 ) {
	return Ayin_SVG_Icons::get_svg( 'ui', $icon, $size );
}

/**
 * Gets the SVG code for a given social icon.
 */
function ayin_get_social_icon_svg( $icon, $size = 24 ) {
	return Ayin_SVG_Icons::get_svg( 'social', $icon, $size );
}

/**
 * Detects the social network from a URL and returns the SVG code for its icon.
 */
function ayin_get_social_link_svg( $uri, $size = 24 ) {
	return Ayin_SVG_Icons::get_social_link_svg( $uri, $size );
}

/**
 * Display SVG icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function ayin_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Change SVG icon inside all menus if there is supported URL.
	if ( ('primary' === $args->theme_location) || ('social' === $args->theme_location) || ('footer' === $args->theme_location) ) {
		// die('is primary');
		$svg = ayin_get_social_link_svg( $item->url, 26 );
		if ( empty( $svg ) ) {
			return $item_output;
		} else {
			$item_output = str_replace( $args->link_before, '<span class="screen-reader-text">', $item_output );
			$item_output = str_replace( $args->link_after, '</span>' . $svg , $item_output );
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'ayin_nav_menu_social_icons', 10, 4 );
