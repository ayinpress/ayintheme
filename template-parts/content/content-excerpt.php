<?php
/**
 * Template part for displaying post archives and search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Ayin
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header default-max-width">
		<?php
		// figure out if this post has an author
		$journalAuthor = get_field('artist_name', get_the_ID());
		$folioAuthor = get_field('folio_artist_name', get_the_ID());
		$columnAuthor = get_field('column_author_name', get_the_ID());
		$zineAuthor 	= get_field('zine_author_names', get_the_ID());
		if (!empty ($journalAuthor)) {
			$postAuthor = $journalAuthor;
		} elseif (!empty ($folioAuthor)) {
			$postAuthor = $folioAuthor;
		} elseif (!empty ($columnAuthor)) {
			$postAuthor = $columnAuthor;
		} elseif (!empty ($zineAuthor)) {
			$postAuthor = $zineAuthor;
		} else {
			$postAuthor = '';
		}
		if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( '<span class="sticky-post">%s</span>', _x( 'Featured', 'post', 'ayin' ) );
		}
		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		// if author exists, display it under title
		if (!empty ($postAuthor)) { ?>
			<div class="entry-meta">
				<span class="byline">
					<span class="author-prefix">by</span> <span class="author vcard"><?php echo $postAuthor; ?></span>
				</span>
			</div><?php
		}
		?>
	</header><!-- .entry-header -->

	<?php ayin_post_thumbnail(); ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer default-max-width">
		<?php ayin_entry_meta_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-${ID} -->
