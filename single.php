<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Ayin
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php

			/* Start the Loop */
			while ( have_posts() ) :

				$categories = get_the_category();
				$journal_number = false;

				foreach ($categories as $cat) {
					if ( strpos( $cat->slug, 'ayin-') !== false ) {
						$journal_number = $cat->slug;
						$journal_name = $cat->name;
					}
				}

				if ( $journal_number !== false ){
					$toc = new WP_Query( array( 'category_slug' => $journal_number )  );
					if ( $toc->posts ){

						echo( 
							sprintf('<section id="journal-toc"><button id="toggle-toc"><span>Table of Contents</span></button><div><p class="journal-title">%1$s</p><ul>', 
								$journal_name ) 
						);
						foreach ($toc->posts as $work){
							$artist_name = 'Anonymous';
							// This is an ACF function so would error if not installed
							if ( function_exists( 'get_field' ) ) {
								$artist_name = get_field( 'artist_name' , $work->ID );
							}
							$work_permalink = get_permalink( $work->ID );
							echo(sprintf( '<li><a href="%1$s">%2$s</a></li>', $work_permalink, $artist_name ) );
						}

						echo( '</ul></div></section>');
					}
			?>

			<?php
					wp_reset_postdata();
				}

				the_post();

				get_template_part( 'template-parts/content/content-single' );

				ayin_the_post_navigation();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
