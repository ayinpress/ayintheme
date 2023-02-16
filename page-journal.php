<?php/** * The template for displaying the Columns page * * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post * * @package Ayin * @since 1.0.0 */get_header();?><section id="primary" class="content-area">	<main id="main" class="site-main" role="main"><?php		// define these two variables here so we can access them in JavaScript at bottom of file		$defaultImage = '';		$defaultCaption = '';		while ( have_posts() ) : ?>		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>			<div class="entry-content"><?php				wp_reset_postdata();				the_post();				the_content(					sprintf(						wp_kses(						/* translators: %s: Name of current post. Only visible to screen readers */							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ayin' ),							array(								'span' => array(									'class' => array(),								),							)						),						get_the_title()					)				);				echo(					'<div class="columns-page-container alignwide">						<div class="columns-grid">'				);				$all_categories = get_categories( array(					'parent' => '0' //get top level categories only				));				// look for the category id for the "Column" category only				$columnsCatId = 0;				$child_cats = null;				foreach( $all_categories as $single_category ){					if ($single_category->slug == 'column') {						$columnsCatId = $single_category->cat_ID;					}				}				// get children of "Column" category only				if ($columnsCatId > 0) {					$child_cats = get_categories( array(						'child_of' => $columnsCatId						//category_display_order					));				}				// display list of columns categories and the posts associated with each				if ($child_cats) {					// first, get them in the right order (reverse display order, so highest number first					$sorted_cats = array();					foreach($child_cats as $cat){						$sorted_cats[] = array(							'd' => get_field('category_date_field', 'category_' . $cat->term_id),							'cat' => $cat						);					}					// sort by date using custom function at bottom of this file					usort($sorted_cats, 'date_compare');					// second, display each column					$firstItem = true;										echo '	<div class="ColumnChildren">';					foreach( $sorted_cats as $child_cat ){						$childID = $child_cat['cat']->cat_ID;						if (!empty($child_cat['d'])) {							$columnDate = DateTime::createFromFormat('m/d/Y', $child_cat['d']);						} else {							$columnDate = null;						}						// get list of all posts within this category and set column category settings						$columnName = $child_cat['cat']->name;						$columnDescription = $child_cat['cat']->description;						$columnLink = get_term_link( $child_cat['cat'] );						$sorted_posts = array();						$posts = get_posts( array(							'cat' => $childID,							'posts_per_page' => 3						));						if (sizeof($posts) > 0) {							foreach ($posts as $post) {								$sorted_posts[] = array(									'display_order' => get_field('column_order', $post->ID),									'title' => $post->post_title,									'post' => $post,								);							}							// sort by display_order and then title							//usort($sorted_posts, 'post_compare');						}						echo '			<h2 class="ColumnTitle">' . esc_attr($columnName) . '</h2>';						echo '			<p class="ColumnDescription">' . $columnDescription . '<p>';						echo '			<div class="ColumnChild">';						foreach ($sorted_posts as $item) {							$columnTitle = get_the_title($item['post']->ID);							$columnPermalink = get_permalink($item['post']->ID);							$columnThumbnail = get_the_post_thumbnail_url($item['post']->ID, 'single-post-thumbnail');							$columnExcerpt = get_the_excerpt($item['post']->ID);							$columnAuthor = get_field('column_author_name', $post->ID);							$postCat = get_the_category($post->ID);							if ($postCat) {								if ($postCat[0]->category_parent == 0) {									$catName = $postCat[0]->name;									$catSlug = $postCat[0]->slug;								} else {									$parentCat = get_category($postCat[0]->category_parent);									$catName = $parentCat->name;									$catSlug = $parentCat->slug;								}							} else {								$catName = '';								$catSlug = '';							}							if (has_post_thumbnail()) {								$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($item['post']->ID), 'full');								$thumbnail_url = $thumbnail[0];								echo('		<article class="ColumnArticle" data-thumbnail="' . esc_attr($columnThumbnail) . '" data-title="' . esc_attr($columnTitle) . '">');								echo('			<a href="' . $columnPermalink . '" class="GridThumb" style="background-image:url(' . $thumbnail_url . '"></a>');								echo('			<div class="entry-wrapper">');								if (!empty($catName) && !empty($catSlug)) {									echo('				<div class="entry-meta">');									echo('					<div class="cat-links"><a href="https://ayinpress.org/category/' . $catSlug . '/">' . esc_html($catName) . '</a></div>');									echo('				</div>');								}								echo('				<h2 class="ArticleTitle entry-title"><a href="' . $columnPermalink . '">' . esc_html($columnTitle) . '</a></h2>');								echo('				<div class="ColumnExcerpt"><p>' . $columnExcerpt . '</p></div>');								if (!empty ($columnAuthor)) {									echo('			<div class="entry-meta">');									echo('				<span class="byline">');									echo('					<span class="author-prefix">by</span> <span class="author vcard">' . $columnAuthor . '</span>');									echo(' 				</span>');									echo('			</div>');								}								echo('			</div>');								echo('		</article>');							}						}						echo('		</div>');						echo('		<a class="PostGrid" href="' . $columnLink . '" data-title="' . esc_attr($columnName) . '">See More</a>');						echo('		<div class="PostGridSpacer"></div>');						wp_reset_postdata();					}					echo('	</div>');					echo(					'	</div>					</div>					');				}				endwhile; // End of the loop. ?>			</div>		</article><!-- #post-<?php the_ID(); ?> -->	</main><!-- #main --></section><!-- #primary --><?phpget_footer();// compare by datefunction date_compare($element1, $element2) {	$datetime1 = strtotime($element1['d']);	$datetime2 = strtotime($element2['d']);	return $datetime2 - $datetime1;}// compare by display order first; if those are equal, then display by title alphabetically - not using this as of 11/3/22 - displaying by published datefunction post_compare($element1, $element2) {	$displayOrder1 = $element1['display_order'];	$displayOrder2 = $element2['display_order'];	if (empty($displayOrder1)) {		$displayOrder1 = 100;	} else {		$displayOrder1 = intval($displayOrder1);	}	if (empty($displayOrder2)) {		$displayOrder2 = 100;	} else {		$displayOrder2 = intval($displayOrder2);	}	if ($displayOrder1 == $displayOrder2) {		return strcmp($element1['title'], $element2['title']);	} else {		return $displayOrder1 - $displayOrder2;	}}