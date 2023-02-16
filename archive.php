<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Ayin
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header alignwide">
				<?php the_archive_title(); ?>
				<?php the_archive_description('<div class="archive-description">', '</div>'); ?>
			</header><!-- .page-header -->
			<?php
				$catID = get_queried_object_id();
				$numberColumns = get_field('grid_columns_display', 'category_' . $catID);
				?>
			<div class="PostsGridWrapper <?php if($numberColumns == 'one') : echo 'One'; elseif($numberColumns == 'two') : echo 'Two'; elseif($numberColumns == 'three') : echo 'Three'; elseif($numberColumns == 'four') : echo 'Four'; else : echo 'Five'; endif; ?>">
				<div class="BlogGrid <?php if($numberColumns == 'one') : echo 'One'; elseif($numberColumns == 'two') : echo 'Two'; elseif($numberColumns == 'three') : echo 'Three'; elseif($numberColumns == 'four') : echo 'Four'; else : echo 'Five'; endif; ?>" id="BlogGridContent">
			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();
				echo display_grid_article($post);

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				//get_template_part( 'template-parts/content/content', get_theme_mod( 'archive_display_excerpt_or_full_post', 'full' ) );

				// End the loop.
			endwhile; ?>
				</div>
			</div>
			<?php
			// Numbered pagination.
			ayin_the_posts_pagination();

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content/content-none' );

		endif;
		?>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
