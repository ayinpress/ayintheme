<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ayin
 * @since 1.0.0
 */
$has_primary_nav = has_nav_menu( 'primary' );
$header_classes  = 'site-header header_classes';
$header_classes .= has_custom_logo() ? ' has-logo' : '';
$header_classes .= true === get_theme_mod( 'display_title_and_tagline', true ) ? ' has-title-and-tagline' : '';
$header_classes .= $has_primary_nav ? ' has-menu' : '';
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="preload" as="font" href="https://p.typekit.net/p.css?s=1&k=gsf4ocl&ht=tk&f=8482.8483.8484.8485&a=26349979&app=typekit&e=css" type="font/ttf" crossorigin="anonymous">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'ayin' ); ?></a>

		<header id="masthead" class="<?php echo $header_classes; ?>" role="banner">
			<?php get_template_part( 'template-parts/header/site-branding' ); ?>

			<?php if ( $has_primary_nav ) : ?>
				<nav id="site-navigation" class="primary-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Main', 'ayin' ); ?>">
					<button id="primary-close-menu" class="button close">
						<span class="dropdown-icon close"><?php echo ayin_get_icon_svg( 'close' ); ?></span>
						<span class="hide-visually collapsed-text"><?php _e( 'collapsed', 'ayin' ); ?></span>
					</button>
					<?php
					// Get menu slug
					$location_name = 'primary';
					$locations     = get_nav_menu_locations();
					$menu_id       = $locations[ $location_name ];
					$menu_obj      = wp_get_nav_menu_object( $menu_id );

					wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'menu_class'      => 'menu-wrapper',
							'container_class' => 'primary-menu-container',
							'link_before'    => '<span>',
							'link_after'     => '</span>',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						)
					);
					?>
				</nav><!-- #site-navigation -->
			<?php endif; ?>
			<!-- 10-11-21 -- moved Social Media icons code to /templates/header/site-branding.php --> 
		</header><!-- #masthead -->

	<div id="content" class="site-content">
