<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Ayin
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function ayin_woocommerce_setup() {
	add_theme_support( 'woocommerce', apply_filters( 'ayin_woocommerce_args', array(
		'single_image_width'    => 750,
		'thumbnail_image_width' => 350,
		'product_grid'          => array(
			'default_columns' => 3,
			'default_rows'    => 6,
			'min_columns'     => 1,
			'max_columns'     => 3,
			'min_rows'        => 1
		)
	) ) );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'ayin_woocommerce_setup' );

/**
 * Add a custom wrapper for woocomerce content
 */
function ayin_content_wrapper_start() {
	echo '<article id="woocommerce-wrapper" class="wide-max-width">';
}
add_action('woocommerce_before_main_content', 'ayin_content_wrapper_start', 10);

function ayin_content_wrapper_end() {
	echo '</article>';
}
add_action('woocommerce_after_main_content', 'ayin_content_wrapper_end', 10);

/**
 * Add a custom wrapper for woocomerce cart
 */
function ayin_cart_wrapper_start() {
	echo '<div id="woocommerce-cart-wrapper" class="wide-max-width">';
}
add_action('woocommerce_before_cart', 'ayin_cart_wrapper_start', 10);
add_action('woocommerce_before_checkout_form', 'ayin_cart_wrapper_start', 10);

function ayin_cart_wrapper_end() {
	echo '</div>';
}
add_action('woocommerce_after_cart', 'ayin_cart_wrapper_end', 10);
add_action('woocommerce_after_checkout_form', 'ayin_cart_wrapper_end', 10);

/**
 * Add a custom wrapper for woocomerce my-account
 */
function ayin_my_account_wrapper_start() {
	echo '<div id="woocommerce-my-account-wrapper" class="wide-max-width">';
}
add_action('woocommerce_before_account_navigation', 'ayin_my_account_wrapper_start', 10);
add_action('woocommerce_before_customer_login_form', 'ayin_my_account_wrapper_start', 10);

function ayin_my_account_wrapper_end() {
	echo '</div>';
}
add_action('woocommerce_account_dashboard', 'ayin_my_account_wrapper_end', 10);
add_action('woocommerce_after_customer_login_form', 'ayin_my_account_wrapper_end', 10);

/**
 * Display category image on category archive
 */
function ayin_category_image() {
    if ( is_product_category() ){
		global $wp_query;
		$cat = $wp_query->get_queried_object();
		$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
		$image = wp_get_attachment_url( $thumbnail_id );
		if ( $image ) {
			echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $cat->name ) . '" />';
		}
	}
}
add_action( 'woocommerce_archive_description', 'ayin_category_image', 2 );

/**
 * Remove WooCommerce Sidebar
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Enqueue scripts and styles.
 */
function ayin_woocommerce_scripts() {

	// WooCommerce styles
	wp_enqueue_style( 'ayin-woocommerce-style', get_template_directory_uri() . '/assets/css/style-woocommerce.css', array(), wp_get_theme()->get( 'Version' ) );

	// WooCommerce RTL styles
	wp_style_add_data( 'ayin-woocommerce-style', 'rtl', 'replace' );

}
add_action( 'wp_enqueue_scripts', 'ayin_woocommerce_scripts' );

/**
 * Setup cart link for main menu
 */
if ( ! function_exists( 'ayin_cart_link' ) ) {
	/**
	 * Cart Link
	 * Display a link to the cart including the number of items present and the cart total
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function ayin_cart_link() {

		$link_output = sprintf(
			'<a class="woocommerce-cart-link" href="%1$s" title="%2$s">
				%3$s
				<span class="woocommerce-cart-subtotal">%4$s</span>
				<small class="woocommerce-cart-count">%5$s</small>
			</a>',
			esc_url( wc_get_cart_url() ),
			esc_attr__( 'View your shopping cart', 'ayin' ),
			ayin_get_icon_svg( 'shopping_cart', 16 ),
			wp_kses_post( WC()->cart->get_cart_subtotal() ),
			wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'ayin' ), WC()->cart->get_cart_contents_count() ) )
		);

		return $link_output;
	}
}

/**
 * Setup cart fragments
 */
if ( ! function_exists( 'ayin_cart_subtotal_fragment' ) ) {
	/**
	 * Cart Subtotal Fragments
	 * Ensure cart subtotal amount update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function ayin_cart_subtotal_fragment( $fragments ) {
		ob_start();
		echo '<span class="woocommerce-cart-subtotal">' . wp_kses_post( WC()->cart->get_cart_subtotal() ) . '</span>';
		$fragments['.woocommerce-cart-subtotal'] = ob_get_clean();
		return $fragments;
	}
}

if ( ! function_exists( 'ayin_cart_count_fragment' ) ) {
	/**
	 * Cart Count Fragments
	 * Ensure cart item count update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function ayin_cart_count_fragment( $fragments ) {
		ob_start();
		echo '<small class="woocommerce-cart-count">' . wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'ayin' ), WC()->cart->get_cart_contents_count() ) ) . '</small>';
		$fragments['.woocommerce-cart-count'] = ob_get_clean();
		return $fragments;
	}
}

/**
 * Setup cart widget for mini-cart dropdown
 */
if ( ! function_exists( 'ayin_cart_widget' ) ) {
	/**
	 * Cart Items List
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function ayin_cart_widget() {
		ob_start();
		the_widget( 'WC_Widget_Cart', 'title=' );
		$widget_output = ob_get_contents();
		ob_end_clean();
		return $widget_output;
	}
}

/**
 * Add cart fragment filters
 *
 * @see ayin_cart_subtotal_fragment() and ayin_cart_count_fragment()
 */
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'ayin_cart_subtotal_fragment', 10, 1 );
	add_filter( 'woocommerce_add_to_cart_fragments', 'ayin_cart_count_fragment', 10, 1 );
} else {
	add_filter( 'add_to_cart_fragments', 'ayin_cart_subtotal_fragment' );
	add_filter( 'add_to_cart_fragments', 'ayin_cart_count_fragment' );
}

// Get rid of stuff you don't want to show
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );