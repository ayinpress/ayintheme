<?php
/**
 * Displays the buttons for opening the mobile menus
 *
 * @package Ayin
 * @since 1.0.0
 */
?>

<div class="menu-button-container">
	<button id="primary-open-menu" class="button open">
		<span class="dropdown-icon open"><?php echo ayin_get_icon_svg( 'menu' ); ?></span>
		<span class="hide-visually expanded-text"><?php _e( 'expanded', 'ayin' ); ?></span>
	</button>
	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
		<button id="woo-open-menu" class="button open">
			<span class="dropdown-icon open"><?php echo ayin_get_icon_svg( 'shopping_cart' ); ?></span>
			<span class="hide-visually expanded-text"><?php esc_html__( 'expanded', 'ayin' ); ?></span>
		</button>
	<?php endif; ?>
</div>