<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Ayin
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header default-max-width">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php if ( ! is_page() ) : ?>
		<div class="entry-meta">
			<?php ayin_entry_meta_header(); ?>
		</div><!-- .meta-info -->
		<?php endif; ?>
	</header>

	<?php ayin_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ayin' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'ayin' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer default-max-width">
		<?php ayin_entry_meta_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php ayin_author_bio(); ?>

</article><!-- #post-${ID} -->
