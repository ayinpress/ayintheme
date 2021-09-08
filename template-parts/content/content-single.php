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
		<?php if ( ! is_page() ) : ?>
		<div class="entry-meta">
			<?php ayin_entry_meta_header(); ?>
		</div><!-- .meta-info -->
		<?php endif; ?>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); 
			$folioArtist = get_field('folio_artist_name');

			if (!empty($folioArtist)) {
				echo( '<p class="artist-credit">By ' . $folioArtist . '</p>' );
			}
		?>
		<?php 
			if ( function_exists( 'get_field' ) ) {
				$artwork_subheader = get_field( 'artwork_subheader' );

				if ( $artwork_subheader ){
					printf( '<p class="artwork-subheader">%s</p>', $artwork_subheader );
				}

				$artist_name = get_field( 'artist_name' );
				if ( $artist_name ){
					printf( '<p class="artist-credit">By %s</p>', $artist_name );
				}
			}
		?>
	</header>

	<div class="entry-content">
		<?php
			// get thumbnail for this page
			if (has_post_thumbnail(get_queried_object_id())) {
				$thumb = get_the_post_thumbnail(get_queried_object_id());
			} else {
				$thumb = '';
			}
			if (!empty ($thumb) && (in_category('82'))) {
				echo '<div class="FolioFeaturedImg">';
				echo $thumb;
				echo '</div>';
			};
		?>
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

</article><!-- #post-${ID} -->
