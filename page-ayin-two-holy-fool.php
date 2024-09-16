<?php
/**
 * The template for displaying the Journal Two page
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

			<div class="entry-content"><?php
				$works = array(); // in case you need it later
				$tocTwo = new WP_Query( array( 'category_name' => 'ayin-two', 'nopaging' => true )  );

				foreach($tocTwo->posts as $post) {
					$work = new stdClass();
					$work->name = get_field( 'artist_name' , $post->ID );
					$work->text = get_field( 'text_after_author' , $post->ID );
					$work->permalink = get_permalink( $work->ID );
					$work->thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];
					$work->title = $post->post_title;
					// TODO: pull out artist name and work title
					if ( $post->post_name !== 'the-holy-fool-editors-note' ) $works[] = $work;
				}

				// usort($works, function($a, $b){ return strcmp($a->name, $b->name); });
				$leftCol = '';
				$rightCol = '';
				$workCount = 0;
				foreach($works as $work) {
					if ($work->title == 'The Moon') {
						continue;
					}
					$workCount++;
					if ($workCount <= (sizeof($works)/2)) {
						$leftCol .= '<li class="journal-artist-preview AyinTwo" data-thumbnail="' . $work->thumbnail . '" data-title="' . esc_attr($work->title) . '"><a href="' . $work->permalink . '">' . $work->name . $work->text . '</a><img src="' . $work->thumbnail . '"></li>';
					} else {
						$rightCol .= '<li class="journal-artist-preview AyinTwo" data-thumbnail="' . $work->thumbnail . '" data-title="' . esc_attr($work->title) . '"><a href="' . $work->permalink . '">' . $work->name . $work->text . '</a><img src="' . $work->thumbnail . '"></li>';
					}
				}

				// load the info about the Editor's Post for this Journal (post #5212)
				$editorsNotePostId = 5212;
				$editorsNoteThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $editorsNotePostId ), 'single-post-thumbnail' )[0];
				$editorsNotePermalink = get_permalink( $editorsNotePostId );
				$editorsNoteTitle = get_the_title( $editorsNotePostId );
				?>
				<div class="journal-page-container alignwide AyinTwo">
					<canvas id="lines" style="display: none;"></canvas>
					<div id="JournalHeading" style="text-align: center;"><h1>Ayin Two<br>The Holy Fool</h1>
					<h4 class="editors-note journal-artist-preview" data-thumbnail="<?php echo $editorsNoteThumbnail; ?>" data-title="<?php echo esc_attr($editorsNoteTitle); ?>"><a href="<?php echo esc_attr($editorsNotePermalink); ?>">Editor's Note</a></h4></div>
					<div class="journal-grid AyinTwo">
						<div class="journal-column1 AyinTwo">
							<ul class="journal-toc-list">
								<?php echo $leftCol; ?>
							</ul>
						</div>
						<div id="ayin-two-journal-preview" class="journal-column journal-preview AyinTwo">
							<img id="journal-work-preview"/>
							<p id="journal-work-title"></p>
						</div>
						<div class="journal-column2 AyinTwo">
							<ul class="journal-toc-list" style="text-align: right;">
								<?php echo $rightCol; ?>
							</ul>
						</div>
					</div>
				</div>
				<?php
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

				endwhile; // End of the loop. ?>
				<script> 
					jQuery(function() {
						var journalPreview = document.getElementById('journal-work-preview');
						var journalPreviewTitle = document.getElementById('journal-work-title');

						if (journalPreview && journalPreviewTitle){
							journalPreview.src = "<?php echo $editorsNoteThumbnail; ?>";
							journalPreviewTitle.innerHTML = `<?php echo esc_js($editorsNoteTitle); ?>`;

							var journalArtists = document.getElementsByClassName('journal-artist-preview');
							for ( var i in journalArtists ){
								if (typeof(journalArtists[i]) === 'object'){
									const { thumbnail, title }  = journalArtists[i].dataset;
									if (title === 'The Moon') continue;
									journalArtists[i].addEventListener('mouseover', function(){
										journalPreview.src = `${thumbnail}`;
										journalPreviewTitle.innerHTML = `${title}`;
									});
								}
							}
						}
					});
				</script>
				</div>
			</article><!-- #post-<?php the_ID(); ?> -->
		</main><!-- #main -->
	</section><!-- #primary -->
	
<?php
get_footer();
