<?php
/**
 * Template part for displaying search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Ayin
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('search-item'); ?>>
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
		} ?>

        <div class="SearchResultsText">
            <h3><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3><?php
	        if (!empty ($postAuthor)) { ?>
                <div class="entry-meta">
                    <span class="byline">
                        <span class="author-prefix">by</span> <span class="author vcard"><?php echo $postAuthor; ?></span>
                    </span>
                </div><?php
	        } ?>
            <div class="entry clearfix"><?php the_excerpt(); ?></div>
        </div><?php
		if ( has_post_thumbnail()) {
			$imagePath = get_the_post_thumbnail_url(null, 'large');
		} else {
			$imagePath = '/wp-content/uploads/2021/04/Ayin-logo-ko-1024x792.jpg';
		} ?>
        <div class="SearchResultsImageWrapper">
            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><div class="SearchResultsImage" style="background-image: url('<?php echo $imagePath; ?>');"></div></a>
        </div>
        <div class="clear"></div>
	</header><!-- .entry-header -->


	<footer class="entry-footer default-max-width">
		<?php ayin_entry_meta_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-${ID} -->
