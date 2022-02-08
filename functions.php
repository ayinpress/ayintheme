<?php
/**
 * Ayin functions and definitions!
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ayin
 * @since 1.1.0
 */

/**
 * ayin only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

if ( ! function_exists( 'ayin_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ayin_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ayin, use a find and replace
		 * to change 'ayin' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ayin', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Navigation', 'ayin' ),
				'footer'  => __( 'Footer Navigation', 'ayin' ),
				'social'  => __( 'Social Links Navigation', 'ayin' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 240,
				'width'       => 240,
				'flex-width'  => true,
				'flex-height' => false,
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		$editor_stylesheet_path = './assets/css/style-editor.css';

		// Enqueue editor styles.
		add_editor_style(
			array(
				ayin_fonts_url(),
				'./assets/css/style-editor.css',
			)
		);

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Tiny', 'ayin' ),
					'shortName' => __( 'XS', 'ayin' ),
					'size'      => 14,
					'slug'      => 'tiny',
				),
				array(
					'name'      => __( 'Small', 'ayin' ),
					'shortName' => __( 'S', 'ayin' ),
					'size'      => 16,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'ayin' ),
					'shortName' => __( 'M', 'ayin' ),
					'size'      => 18,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'ayin' ),
					'shortName' => __( 'L', 'ayin' ),
					'size'      => 24,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'ayin' ),
					'shortName' => __( 'XL', 'ayin' ),
					'size'      => 50,
					'slug'      => 'huge',
				),
				array(
					'name'      => __( 'XXL', 'ayin' ),
					'shortName' => __( 'XXL', 'ayin' ),
					'size'      => 71,
					'slug'      => 'xxl',
				),
			)
		);

		// Editor color palette.
		$colors_theme_mod = get_theme_mod( 'custom_colors_active' );
		$primary          = ( ! empty( $colors_theme_mod ) && 'default' === $colors_theme_mod || empty( get_theme_mod( 'ayin_--global--color-primary' ) ) ) ? '#20a181' : get_theme_mod( 'ayin_--global--color-primary' );
		$secondary        = ( ! empty( $colors_theme_mod ) && 'default' === $colors_theme_mod || empty( get_theme_mod( 'ayin_--global--color-secondary' ) ) ) ? '#efa182' : get_theme_mod( 'ayin_--global--color-secondary' );
		$foreground       = ( ! empty( $colors_theme_mod ) && 'default' === $colors_theme_mod || empty( get_theme_mod( 'ayin_--global--color-foreground' ) ) ) ? '#333333' : get_theme_mod( 'ayin_--global--color-foreground' );
		$tertiary         = ( ! empty( $colors_theme_mod ) && 'default' === $colors_theme_mod || empty( get_theme_mod( 'ayin_--global--color-tertiary' ) ) ) ? '#fff3e4' : get_theme_mod( 'ayin_--global--color-tertiary' );
		$background       = ( ! empty( $colors_theme_mod ) && 'default' === $colors_theme_mod || empty( get_theme_mod( 'ayin_--global--color-background' ) ) ) ? '#fefcfc' : get_theme_mod( 'ayin_--global--color-background' );

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'ayin' ),
					'slug'  => 'primary',
					'color' => $primary,
				),
				array(
					'name'  => __( 'Secondary', 'ayin' ),
					'slug'  => 'secondary',
					'color' => $secondary,
				),
				array(
					'name'  => __( 'Foreground', 'ayin' ),
					'slug'  => 'foreground',
					'color' => $foreground,
				),
				array(
					'name'  => __( 'Tertiary', 'ayin' ),
					'slug'  => 'tertiary',
					'color' => $tertiary,
				),
				array(
					'name'  => __( 'Background', 'ayin' ),
					'slug'  => 'background',
					'color' => $background,
				),
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );

		// Add support for experimental link color control.
		add_theme_support( 'experimental-link-color' );

		// Add support for experimental cover block spacing.
		add_theme_support( 'experimental-custom-spacing' );

		// Add support for custom units.
		add_theme_support( 'custom-units' );

		// Add support for WordPress.com Global Styles.
		add_theme_support(
			'jetpack-global-styles',
			array(
				'enable_theme_default' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'ayin_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ayin_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Footer', 'ayin' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'ayin' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ayin_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width.
 */
function ayin_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ayin_content_width', 620 );
}
add_action( 'after_setup_theme', 'ayin_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function ayin_scripts() {
	// Enqueue Google fonts
	wp_enqueue_style( 'ayin-fonts', ayin_fonts_url(), array(), null );

	// Theme styles
	wp_enqueue_style( 'ayin-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
	// new stylesheet added for new styles outside of using SASS - InterlockSolutions
	wp_enqueue_style( 'updates-ayin-style', get_template_directory_uri() . '/style-updates.css', array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_style( 'baguettebox-css', get_template_directory_uri() . '/assets/vendor/baguetteBox.min.css', wp_get_theme()->get( 'Version' ), true );

	// Navigation styles
	wp_enqueue_style( 'ayin-style-navigation', get_template_directory_uri() . '/assets/css/style-navigation.css', array(), wp_get_theme()->get( 'Version' ) );

	// RTL styles
	wp_style_add_data( 'ayin-style', 'rtl', 'replace' );
	wp_style_add_data( 'ayin-style-navigation', 'rtl', 'replace' );

	// Print styles
	wp_enqueue_style( 'ayin-print-style', get_template_directory_uri() . '/assets/css/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

	// Threaded comment reply styles
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// UI scripts
	wp_enqueue_script( 'ayin-lottie', 'https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie_svg.min.js', array(), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'baguettebox', get_template_directory_uri() . '/assets/vendor/baguetteBox.min.js', array(), false );
	wp_enqueue_script( 'ayin-ui-js', get_template_directory_uri() . '/assets/js/ui.js', array( 'ayin-lottie', 'baguettebox' ), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'ayin_scripts' );

function holy_fool_scripts() {
	/* 3087 is holy fool TOC */
	global $post;
	if ($post->ID == 3087) {
		wp_enqueue_script( 'lines-base', get_template_directory_uri() . '/assets/holy_fool/base.min.js', array( 'ayin-lottie', 'baguettebox' ), wp_get_theme()->get( 'Version' ), true );
		wp_enqueue_script( 'lines-game', get_template_directory_uri() . '/assets/holy_fool/game.min.js', array( 'ayin-lottie', 'baguettebox' ), wp_get_theme()->get( 'Version' ), true );
		wp_enqueue_script( 'holy-fool', get_template_directory_uri() . '/assets/holy_fool/fool.min.js', array( 'ayin-lottie', 'baguettebox' ), wp_get_theme()->get( 'Version' ), true );

		$translation_array = array( 'foolURL' => get_template_directory_uri() );

		wp_localize_script( 'holy-fool', 'fool_dir', $translation_array );
	}
}
add_action( 'wp_enqueue_scripts', 'holy_fool_scripts' );


/**
 * Allow the fonts to be filterable for child themes.
 */
function ayin_fonts_url( ){
	return get_template_directory_uri() . '/assets/css/fonts.css';
}

/**
 * Enqueue theme styles for the block editor.
 */
function ayin_editor_styles() {
	wp_enqueue_style( 'ayin-editor-fonts', ayin_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'ayin_editor_styles' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function ayin_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'ayin_skip_link_focus_fix' );


if ( ! function_exists( 'ayin_author_bio' ) ) {
	/**
	 * Implements the Jetpack Author bio
	 */
	function ayin_author_bio() {
		if ( ! function_exists( 'jetpack_author_bio' ) ) {
			if ( ! is_singular( 'attachment' ) ) {
				get_template_part( 'template-parts/post/author-bio' );
			}
		} else {
			jetpack_author_bio();
		}
	}
}

function register_assets() {
	wp_register_script( 'baguettebox', plugin_dir_url( __FILE__ ) . 'dist/baguetteBox.min.js', [], '1.11.1', true );
	wp_add_inline_script( 'baguettebox', '' );
	wp_register_style( 'baguettebox-css', plugin_dir_url( __FILE__ ) . 'dist/baguetteBox.min.css', [], '1.11.1' );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\register_assets' );

function enqueue_assets() {
	if ( has_block( 'gallery' ) || has_block( 'image' ) || get_post_gallery() ) {
		wp_enqueue_script( 'baguettebox' );
		wp_enqueue_style( 'baguettebox-css' );
	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );

/**
 * SVG Icons class.
 */
require get_template_directory() . '/classes/class-ayin-svg-icons.php';

/**
 * Enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * SVG Icons related functions.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Custom template tags for the theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Block Patterns.
 */
require get_template_directory() . '/inc/block-patterns.php';

/**
 * Block Styles.
 */
require get_template_directory() . '/inc/block-styles.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


// Add Print Button Shortcode
function ayin_print_button_shortcode( $atts ){
	$printIcon = ayin_get_icon_svg( 'printer' );
return '<span class="print-button"><a class="print-page" href="javascript:window.print()"><span class="PrintIcon">' . $printIcon . '</span>Print</a></span>';
}
add_shortcode( 'ayin_print_button', 'ayin_print_button_shortcode' );

// Add Category nicename to body class
add_filter('body_class','add_category_to_single');
function add_category_to_single($classes) {
	if (is_single() ) {
		global $post;
		foreach((get_the_category($post->ID)) as $category) {
		// add category slug to the $classes array
		$classes[] = $category->category_nicename;
	}
}
	// return the $classes array
	return $classes;
}

/* Add body-class for top-level parent Page or Category */
function parent_category_body_class( $class ) {
	$prefix = 'parent-'; // Editable class name prefix.
	$top_cat_pg = 'home'; // Default.
	global $top_cat_pg;

	// Get class name from top-level Category or Page.
	global $wp_query;
	if ( is_single() ) {
		$wp_query->post = $wp_query->posts[0];
		setup_postdata( $wp_query->post );
		 /* Climb Posts category hierarchy, successively replacing
		 class name top_cat_pg with slug of higher level cat. */
		foreach( (array) get_the_category() as $cat ) {
			if ( !empty( $cat->slug ) )
				$top_cat_pg = sanitize_html_class( $cat->slug, $cat->cat_ID );
			while ( $cat->parent ) {
				$cat = &get_category( (int) $cat->parent);
				if ( !empty( $cat->slug ) )
					$top_cat_pg = sanitize_html_class( $cat->slug, $cat->cat_ID );
			}
		}
	} elseif ( is_archive() ) {
		if ( is_category() ) {
			$cat        = $wp_query->get_queried_object();
			$top_cat_pg = $cat->slug;
			/* Climb Category hierarchy, successively replacing
			class name with slug of higher level cat. */
			while ( $cat->parent ) {
				$cat = &get_category( (int) $cat->parent );
				if ( !empty( $cat->slug ) )
					$top_cat_pg = sanitize_html_class( $cat->slug, $cat->cat_ID );
			}
		}
	} elseif ( is_page() ) {
		global $post;
		if ( $post->post_parent )	{
			$ancestors  = get_post_ancestors( $post->ID );
			$root       = count( $ancestors ) - 1;
			$top_id     = $ancestors[$root];
			$top_pg     = get_page( $top_id );
			$top_cat_pg = $top_pg->post_name;
		} else {
			$top_cat_pg = $post->post_name;
		}
	}
	$class[] = $prefix . $top_cat_pg;

	return $class;
}
add_filter( 'body_class', 'parent_category_body_class' );

function ayin_custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'ayin_custom_excerpt_length', 999 );


/**
 * Remove dashboard widgets
 */
function wpdocs_remove_dashboard_widgets(){
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // Recent Comments
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );  // Incoming Links
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );   // Plugins
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );  // Quick Press
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );  // Recent Drafts
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );   // WordPress blog
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );   // Other WordPress News
	remove_meta_box( 'dashboard_activity', 'dashboard', 'side' ); // Activity
	remove_meta_box( 'mc_mm_dashboard_widget', 'dashboard', 'normal' ); // MailMunch
}
add_action( 'admin_init', 'wpdocs_remove_dashboard_widgets' );

/**
 * Add Training module to WP Dashboard
 */
add_action('wp_dashboard_setup', 'ayin_custom_dashboard_widgets');
  
function ayin_custom_dashboard_widgets() {
	global $wp_meta_boxes;
	 
	wp_add_dashboard_widget('custom_training_widget', 'Ayin website training', 'custom_dashboard_training');
}
 
function custom_dashboard_training() {
	echo '<p>We have recorded training videos here for your reference:<br><br>';
	echo '<a href="/wp-content/themes/ayintheme/videos/ayin-folio-posts.mp4" target="_blank" rel="noopener noreferrer">Adding New Folios</a><br><br>';
	echo '</p>';
}

function ayin_posts_grid_function($atts) {
	$options = shortcode_atts( array(
		'category_slug'	=> 'all categories',
		'title'			=> 'From the Archive'
	), $atts );

	if ($options['category_slug'] == 'all categories') {
		// grab latest posts of any category
		$posts = get_posts( array(
			'numberposts'		=> -1,
			'post_type'			=> 'post',
			'order'    			=> 'DESC',
			'category__not_in'	=> array(71),	// don't pull any from "News" category
		) );

	} else {
		// grab latest posts of specific category
		$category = get_category_by_slug($options['category_slug']);
		if ($category) {
			$posts = get_posts( array(
				'numberposts'	=> -1,
				'post_type'		=> 'post',
				'order'    		=> 'DESC',
				'category'		=> $category->term_id,
			) );
		} else {
			$posts = get_posts( array(
				'numberposts'		=> -1,
				'post_type'			=> 'post',
				'order'    			=> 'DESC',
				'category__not_in'	=> array(71),	// don't pull any from "News" category
			) );
		}
	}
	shuffle($posts);

	if (sizeof($posts) > 0) {
		$postList = array();
		foreach ($posts as $post) {
			$postList[] = $post->ID;
		}
		ob_start(); ?>
			<div class="PostsGridWrapper">
				<div class="PostsGridTitle">
					<h2 style="text-align: center;"><?php echo($options['title']); ?></h2>
				</div>
				<div class="BlogGrid" id="BlogGridContent"><?php
					$count = 0;
					foreach ($posts as $post) {
						$count++;
						if ($count < 11) {
							echo display_grid_article($post);
						}
					}
					echo display_grid_load_more_button(11); ?>
				</div><?php
				if (sizeof($posts) > 10) { ?>
					<script>
						function load_ayin_posts(start) {
							var date = new Date();
							var QS = '&start=' + start + '&list=<?php echo urlencode(json_encode($postList)); ?>';
							jQuery('#AyinGridMorePosts' + start).fadeOut('fast', function() {
								jQuery('#AyinGridMorePosts' + start).remove();
								jQuery('#AyinGridLoading' + start).fadeIn('fast', function() {
									jQuery.ajax({
										url: '/wp-content/themes/ayintheme/ajax/load_grid.php?r=' + date.getTime() + QS,
										type: 'GET',
										dataType: 'text',
									}).success(function (results) {
										jQuery('#AyinGridLoading' + start).fadeOut('fast', function() {
											jQuery('#AyinGridLoading' + start).remove();
											jQuery('#BlogGridContent').append(results);
										});
									}).error(function (XMLHttpRequest, textStatus, errorThrown) {
										var errorText = '<div style="padding: 20px; text-align: center; font-weight: 400; font-size: 18px; line-height; 30px;">There was an error while loading more posts. Please try again later.</div>';
										jQuery('#AyinGridLoading').fadeOut('fast', function() {
											jQuery('#BlogGridContent').append(errorText);
										});
									});
								});
							});
						}
					</script><?php
				} ?>
			</div>
		<?php
		return ob_get_clean();
	}
}
add_shortcode( 'Ayin_Posts_Grid', 'ayin_posts_grid_function' );

function display_grid_article($post) {
	$article = '';
	setup_postdata($post);
	$blogTitle = get_the_title($post->ID);
	$blogPermalink = get_permalink($post->ID);
	$blogThumbnail = get_the_post_thumbnail_url('single-post-thumbnail');
	$blogExcerpt = get_the_excerpt($post->ID);
	$urlAuthor = get_author_posts_url(get_the_author_meta('ID'));
	$journalAuthor = get_field('artist_name', $post->ID);
	$folioAuthor = get_field('folio_artist_name', $post->ID);
	$columnAuthor = get_field('column_author_name', $post->ID);
	if (!empty ($journalAuthor)) {
		$postAuthor = $journalAuthor;
	} elseif (!empty ($folioAuthor)) {
		$postAuthor = $folioAuthor;
	} elseif (!empty ($columnAuthor)) {
		$postAuthor = $columnAuthor;
	} else {
		$postAuthor = '';
	}
	$postCat = get_the_category($post->ID);
	if ($postCat) {
		if ($postCat[0]->category_parent == 0) {
			$catName = $postCat[0]->name;
			$catSlug = $postCat[0]->slug;
		} else {
			$parentCat = get_category($postCat[0]->category_parent);
			$catName = $parentCat->name;
			$catSlug = $parentCat->slug;
		}
	} else {
		$catName = '';
		$catSlug = '';
	}

	if (has_post_thumbnail($post->ID)) {
		$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
		$thumbnail_url = $thumbnail[0];
		$article .= '		<article class="BlogGridPost" data-thumbnail="' . esc_attr($blogThumbnail) . '" data-title="' . esc_attr($blogTitle) . '">';
		$article .= '			<a href="' . $blogPermalink . '" class="GridThumb" style="background-image:url(' . $thumbnail_url . '"></a>';
	} else {
		$article .= '		<article class="BlogGridPost" data-thumbnail="" data-title="' . esc_attr($blogTitle) . '">';
		$article .= '			<a href="' . $blogPermalink . '" class="GridThumb"></a>';
	}

	$article .= '			<div class="entry-wrapper">';
	if (!empty($catName) && !empty($catSlug)) {
		$article .= '				<div class="entry-meta">';
		$article .= '					<div class="cat-links"><a href="https://ayinpress.org/category/' . $catSlug . '/">' . esc_html($catName) . '</a></div>';
		$article .= '				</div>';
	}
	$article .= '				<h2 class="ArticleTitle entry-title"><a href="' . $blogPermalink . '">' . esc_html($blogTitle) . '</a></h2>';
	if (!empty ($blogExcerpt)) {
		$article .= '				<div class="BlogExcerpt"><p>' . $blogExcerpt . '</p></div>';
	}
	if (!empty ($postAuthor)) {
		$article .= '				<div class="entry-meta">';
		$article .= '					<span class="byline">';
		$article .= '						<span class="author-prefix">by</span> <span class="author vcard">' . $postAuthor . '</span>';
		$article .= ' 					</span>';
		//$article .= ayin_posted_by();
		//if ( function_exists( 'coauthors_posts_links' ) ) {
		//	$article .= coauthors_posts_links();
		//} else {
		//	$article .= the_author_posts_link();
		//}
		$article .= '				</div>';
	}
	$article .= '			</div>';
	$article .= '		</article>';
	return $article;
}

function display_grid_load_more_button($num) { ?>
	<div id="AyinGridMorePosts<?php echo $num; ?>" class="AyinMorePosts"><button type="button" class="AyinMorePostsButton" onclick="load_ayin_posts(<?php echo $num; ?>);">Load more posts</button></div>
	<div id="AyinGridLoading<?php echo $num; ?>" class="AyinGridLoading"></div><?php
}