<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Ayin
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main searchWrapper" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header default-max-width">
				<?php
				printf(
					/* translators: 1: search result title. 2: search term. */
					'<h1 class="page-title">%1$s <span class="page-description search-term">%2$s</span></h1>',
					__( 'Search results for:', 'ayin' ),
					get_search_query()
				);
				?>
			</header><!-- .page-header -->

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content/search-results-excerpt' );

				// End the loop.
			endwhile;

			// Numbered pagination.
			the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => sprintf(
						'%s <span class="nav-prev-text">%s</span>',
						ayin_get_icon_svg( 'chevron_left', 22 ),
						__( 'Previous', 'ayin' )
					),
					'next_text' => sprintf(
						'<span class="nav-next-text">%s</span> %s',
						__( 'Next', 'ayin' ),
						ayin_get_icon_svg( 'chevron_right', 22 )
					),
				)
			);

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content/content-none' );

		endif;
		?>
		</main><!-- #main -->
	</section><!-- #primary -->

    <style>
        .searchWrapper article {
            margin-top: 40px !important;
            margin-bottom: 40px !important;
        }

        .searchWrapper article header {
            margin-bottom: 0;
        }

        .searchWrapper article .entry-footer {
            margin-top: 40px;
            padding-top: 0;
        }

        .searchWrapper .SearchResultsText {
            float: left;
            width: 70%;
            margin-right: 5%;
            margin-bottom: 0;
            overflow: hidden;
        }

        .searchWrapper .SearchResultsImageWrapper {
            float: right;
            width: 25%;
        }

        .searchWrapper .SearchResultsImage {
            width: 100%;
            padding-bottom: 120%;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 50% 50%;
        }

        .searchWrapper .navigation .nav-links {
            flex-direction: row;
        }
    </style>

<?php
get_footer();
