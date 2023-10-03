<?php // phpcs:disable
/**
 * WPHooks
 *
 * @package wooenvio/wecorreos
 */

require_once __DIR__ . '/Shipping/shipping.php';

if ( ! wp_doing_ajax() ) {

	add_action( 'admin_enqueue_scripts', $cowc_container->raw( 'add_style_on_order_page' ) );
	add_action( 'admin_enqueue_scripts', $cowc_container->raw( 'add_change_tab_js_on_order_page' ) );
}
