<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ayin
 * @since 1.0.0
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo" aria-label="<?php esc_attr_e( 'Footer', 'ayin' ); ?>">

		<div class="alignwide">
		<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
		<nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'ayin' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'menu_class'     => 'footer-menu',
					'depth'          => 1,
				)
			);
			?>
		</nav><!-- .footer-navigation -->
		<?php endif; ?>

		<div class="site-info">
			<?php
			if ( function_exists( 'the_privacy_policy_link' ) ) {
				the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
			}
			?>
		</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
