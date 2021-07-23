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
