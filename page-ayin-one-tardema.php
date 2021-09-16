<?php
/**
 * The template for displaying the Journal page
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

			<?php while ( have_posts() ) : ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="entry-content">
				<?php
					$works = array(); // in case you need it later
					$toc = new WP_Query( array( 'category_name' => 'ayin-one', 'nopaging' => true )  );
					echo(
						'<div class="journal-page-container alignwide">
							<div class="journal-grid">
								<div class="journal-column">
									<h1>Ayin One Tardema</h1>
									<hr></hr>
									<h4 class="editors-note"><a href="/editors-note">Editor\'s Note</a></h4>
									<ul>'
					);
					foreach($toc->posts as $post){
						$work = new stdClass();
						$work->name = get_field( 'artist_name' , $post->ID );
						$work->permalink = get_permalink( $work->ID );
						$work->thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];
						$work->title = $post->post_title;
						// TODO: pull out artist name and work title
						if ( $post->post_name !== 'editors-note' ) $works[] = $work;
					}

					// usort($works, function($a, $b){ return strcmp($a->name, $b->name); });

					foreach($works as $work){
						echo(
							sprintf( '<li class="journal-artist-preview" data-thumbnail="%2$s" data-title="%4$s"><a href="%3$s">%1$s</a><img src="%2$s"></li>', 
								$work->name, 
								$work->thumbnail, 
								$work->permalink,
								$work->title
							)
						);
					}

					echo( 
							'</ul>
							</div>
							<div class="journal-column journal-preview">
								<img id="journal-work-preview"/>
								<p id="journal-work-title"></p>
							</div>
							</div>
						</div'
					);
					wp_reset_postdata();

					the_post();

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

				endwhile; // End of the loop.
				?>
				</div>
			</article><!-- #post-<?php the_ID(); ?> -->
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
