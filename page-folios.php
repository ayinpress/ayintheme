<?php/** * The template for displaying the Folio page * * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post * * @package Ayin * @since 1.0.0 */get_header();?><section id="primary" class="content-area">	<main id="main" class="site-main" role="main"><?php		// define these two variables here so we can access them in JavaScript at bottom of file		$defaultImage = '';		$defaultCaption = '';		while ( have_posts() ) : ?>		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>			<div class="entry-content"><?php				wp_reset_postdata();				the_post();				the_content(					sprintf(						wp_kses(						/* translators: %s: Name of current post. Only visible to screen readers */							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ayin' ),							array(								'span' => array(									'class' => array(),								),							)						),						get_the_title()					)				);				echo(				'<div class="folios-page-container alignwide">						<div class="folios-grid">							<div class="folios-column">'				);				$all_categories = get_categories( array(					'parent' => '0' //get top level categories only				));				// look for the category id for the "folios" category only				$folioCatId = 0;				$child_cats = null;				foreach( $all_categories as $single_category ){					if ($single_category->slug == 'folios') {						$folioCatId = $single_category->cat_ID;					}				}				// get children of "folios" category only				if ($folioCatId > 0) {					$child_cats = get_categories( array(						'child_of' => $folioCatId						//category_display_order					));				}				// display list of folio categories and the posts associated with each				if ($child_cats) {					// first, get them in the right order (reverse display order, so highest number first					$sorted_cats = array();					foreach($child_cats as $cat){						$sorted_cats[] = array(							'd' => get_field('category_date_field', 'category_' . $cat->term_id),							'cat' => $cat						);					}					// sort by date using custom function at bottom of this file					usort($sorted_cats, 'date_compare');					// second, display each folio					$firstItem = true;					echo '<ul class="FolioChildren">';					foreach( $sorted_cats as $child_cat ){						$childID = $child_cat['cat']->cat_ID;						if (!empty($child_cat['d'])) {							$folioDate = DateTime::createFromFormat('d/m/Y', $child_cat['d']);						} else {							$folioDate = null;						}						$folioImagePath = get_field('category_image', 'category_' . $child_cat['cat']->term_id);						$folioName = $child_cat['cat']->name;						if ($firstItem) {							echo '	<li id="folioParent' . $childID . '" class="FolioParentTitle" data-thumbnail="' . esc_attr($folioImagePath) . '" data-title="' . esc_attr($folioName) . '"><a href="javascript:toggle_folio(' . $childID . ');" class="ArrowDown">' . esc_html($folioName) . '</a>';							if ($folioDate) echo ', <span class="FolioDate">' . $folioDate->format('F j, Y') . '</span>';							echo '		<ul id="folioList' . $childID . '" class="FolioArticleTitles">';							$defaultImagePath = $folioImagePath;							$defaultCaption = $folioName;							$firstItem = false;						} else {							echo '	<li id="folioParent' . $childID . '" class="FolioParentTitle" data-thumbnail="' . esc_attr($folioImagePath) . '" data-title="' . esc_attr($folioName) . '"><a href="javascript:toggle_folio(' . $childID . ');" class="ArrowRight">' . esc_html($folioName) . '</a>';							if ($folioDate) echo ', <span class="FolioDate">' . $folioDate->format('F j, Y') . '</span>';							echo '		<ul id="folioList' . $childID . '" class="FolioArticleTitles" style="display: none;">';						}						$query = new WP_Query( array( 'cat' => $childID, 'posts_per_page' => -1 ) );						while( $query->have_posts() ):							$query->the_post();							$folioTitle = get_the_title();							$folioPermalink = get_permalink();							$folioThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-post-thumbnail' )[0];							echo('<li class="folio-article-preview" data-thumbnail="' . esc_attr($folioThumbnail) . '" data-title="' . esc_attr($folioTitle) . '"><a href="' . $folioPermalink . '">' . esc_html($folioTitle) . '</a><img src="' . esc_attr($folioThumbnail) . '"></li>');						endwhile;						wp_reset_postdata();						echo '		</ul>';						echo '	</li>';					}					echo('</ul>');					echo(					'		</div>							<div class="folios-column folio-preview">								<img id="folio-work-preview"/>								<p id="folio-work-title"></p>							</div>						</div>					</div>					');				}				endwhile; // End of the loop. ?>				<script>					function toggle_folio(flid) {						let parentLink = jQuery('#folioParent' + flid + ' > a');						let list = jQuery('#folioList' + flid);						if (list.is(':visible')) {							parentLink.removeClass('ArrowDown');							parentLink.addClass('ArrowRight');						} else {							parentLink.removeClass('ArrowRight');							parentLink.addClass('ArrowDown');						}						list.slideToggle('slow');					}					jQuery(function() {						let folioPreview = document.getElementById('folio-work-preview');						let folioPreviewTitle = document.getElementById('folio-work-title');						if (folioPreview && folioPreviewTitle) {<?php							if (!empty($defaultImagePath)) { ?>								folioPreview.src = '<?php echo esc_js($defaultImagePath); ?>';<?php							} else { ?>								folioPreview.src = '/wp-content/uploads/2021/08/tulips-1000x1000-1.jpg';<?php							}							if (!empty($defaultCaption)) { ?>								folioPreviewTitle.innerHTML = '<?php echo esc_js($defaultCaption); ?>';<?php							} else { ?>								folioPreviewTitle.innerHTML = `Ayin One | Folio`;<?php							} ?>							jQuery('li.folio-article-preview').each(function() {								let thumb = jQuery(this).data('thumbnail');								let title = jQuery(this).data('title');								jQuery(this).children('a').mouseover(function() {									folioPreview.src = thumb;									folioPreviewTitle.innerHTML = title;								});							});							jQuery('li.FolioParentTitle').each(function() {								let thumb = jQuery(this).data('thumbnail');								let title = jQuery(this).data('title');								jQuery(this).children('a').mouseover(function() {									folioPreview.src = thumb;									folioPreviewTitle.innerHTML = title;								});							});						}					});				</script>							</div>		</article><!-- #post-<?php the_ID(); ?> -->	</main><!-- #main --></section><!-- #primary --><?phpget_footer();function date_compare($element1, $element2) {	$datetime1 = strtotime($element1['d']);	$datetime2 = strtotime($element2['d']);	return $datetime2 - $datetime1;}