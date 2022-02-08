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
			$folioArtist 	= get_field('folio_artist_name');
			$columnAuthor 	= get_field('column_author_name');

			if (!empty($folioArtist)) {
				echo( '<p class="artist-credit">By ' . $folioArtist . '</p>' );
			} elseif (!empty($columnAuthor)) {
				echo( '<p class="artist-credit">By ' . $columnAuthor . '</p>' );
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

	<div class="entry-content"><?php
		$all_categories = get_categories( array(
			'parent' => '0' //get top level categories only
		));

		// look for the category id for the "Folio" and "Column" categories only
		$folioCatId = 0;
		$folioChildCats = null;
		$columnChildCats = null;
		foreach( $all_categories as $single_category ){
			if ($single_category->slug == 'folio') {
				$folioCatId = $single_category->cat_ID;
			} elseif ($single_category->slug == 'column') {
				$columnCatId = $single_category->cat_ID;
			}
		}

		// get children of "Folio" or "Column" category only
		if ($folioCatId > 0) {
			$folioChildCats = get_categories( array(
				'child_of' => $folioCatId
			));
		}
		if ($columnCatId > 0) {
			$columnChildCats = get_categories( array(
				'child_of' => $columnCatId
			));
		}

		// get list of categories this post is in
		$objectArray = [];
		$objectArray[] = get_queried_object_id();
		$parent_cats = get_categories(
			array(
				'object_ids' => $objectArray,
			)
		);

		// loop through both arrays to see if there is a match
		$isFolioPost = false;
		if ($folioChildCats && $parent_cats) {
			foreach ($folioChildCats as $child) {
				foreach ($parent_cats as $cat) {
					if ($cat->term_id == $child->term_id) {
						$isFolioPost = true;
						break;
					}
				}
				if ($isFolioPost) break;
			}
		}
		$isColumnPost = false;
		if ($columnChildCats && $parent_cats) {
			foreach ($columnChildCats as $child) {
				foreach ($parent_cats as $cat) {
					if ($cat->term_id == $child->term_id) {
						$isColumnPost = true;
						break;
					}
				}
				if ($isColumnPost) break;
			}
		}


		// get thumbnail for posts only in child of "Folio" or "Column" category
		if ($isFolioPost || $isColumnPost) {
			if (has_post_thumbnail(get_queried_object_id())) {
				$thumb = get_the_post_thumbnail(get_queried_object_id());
			} else {
				$thumb = '';
			}
			if (get_post(get_post_thumbnail_id(get_queried_object_id()))->post_excerpt) {
				$caption = get_post(get_post_thumbnail_id(get_queried_object_id()) )->post_excerpt;
			} else {
				$caption = '';
			}
			if (!empty ($thumb)) {
				echo '<div class="FolioFeaturedImg">';
				echo $thumb;
				if (!empty($caption)) echo '<div class="image-caption">' . $caption . '</div>';
				echo '</div>';
			};
		}

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
