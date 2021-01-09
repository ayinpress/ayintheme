<?php
/**
 * Ayin Theme: Customizer
 *
 * @package Ayin
 * @since 1.0.0
 */

if ( ! class_exists( 'Ayin_Customize' ) ) {
	/**
	 * Customizer Settings.
	 *
	 * @since 1.0.0
	 */
	class Ayin_Customize {

		/**
		 * Constructor. Instantiate the object.
		 *
		 * @access public
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'register' ) );
		}

		/**
		 * Register customizer options.
		 *
		 * @access public
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 *
		 * @return void
		 */
		public function register( $wp_customize ) {

			// Change site-title & description to postMessage.
			$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

			// Add partial for blogname.
			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector'        => '.site-title',
					'render_callback' => array( $this, 'partial_blogname' ),
				)
			);

			// Add partial for blogdescription.
			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector'        => '.site-description',
					'render_callback' => array( $this, 'partial_blogdescription' ),
				)
			);

			/**
			 * Add excerpt or full text selector to customizer
			 */
			$wp_customize->add_section(
				'excerpt_settings',
				array(
					'title'    => esc_html__( 'Excerpt Settings', 'ayin' ),
					'priority' => 120,
				)
			);

			$wp_customize->add_setting(
				'index_display_excerpt_or_full_post',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'full',
					'sanitize_callback' => function( $value ) {
						return 'excerpt' === $value || 'full' === $value ? $value : 'excerpt';
					},
				)
			);

			$wp_customize->add_setting(
				'archive_display_excerpt_or_full_post',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'full',
					'sanitize_callback' => function( $value ) {
						return 'excerpt' === $value || 'full' === $value ? $value : 'excerpt';
					},
				)
			);

			$wp_customize->add_control(
				'index_display_excerpt_or_full_post',
				array(
					'type'    => 'radio',
					'section' => 'excerpt_settings',
					'label'   => esc_html__( 'On the home page, posts show:', 'ayin' ),
					'choices' => array(
						'excerpt' => esc_html__( 'Summary', 'ayin' ),
						'full'    => esc_html__( 'Full text', 'ayin' ),
					),
				)
			);

			$wp_customize->add_control(
				'archive_display_excerpt_or_full_post',
				array(
					'type'    => 'radio',
					'section' => 'excerpt_settings',
					'label'   => esc_html__( 'On archive pages, posts show:', 'ayin' ),
					'choices' => array(
						'excerpt' => esc_html__( 'Summary', 'ayin' ),
						'full'    => esc_html__( 'Full text', 'ayin' ),
					),
				)
			);

			// Add "display_title_and_tagline" setting for displaying the site-title & tagline.
			$wp_customize->add_setting(
				'display_title_and_tagline',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			// Add control for the "display_title_and_tagline" setting.
			$wp_customize->add_control(
				'display_title_and_tagline',
				array(
					'type'    => 'checkbox',
					'section' => 'title_tagline',
					'label'   => esc_html__( 'Display Site Title & Tagline', 'ayin' ),
				)
			);
		}

		/**
		 * Render the site title for the selective refresh partial.
		 *
		 * @access public
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function partial_blogname() {
			bloginfo( 'name' );
		}

		/**
		 * Render the site tagline for the selective refresh partial.
		 *
		 * @access public
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function partial_blogdescription() {
			bloginfo( 'description' );
		}

		/**
		 * Sanitize boolean for checkbox.
		 *
		 * @access public
		 *
		 * @since 1.0.0
		 *
		 * @param bool $checked Whether or not a box is checked.
		 *
		 * @return bool
		 */
		public static function sanitize_checkbox( $checked = null ) {
			return (bool) isset( $checked ) && true === $checked;
		}
	}

	new Ayin_Customize();
}
