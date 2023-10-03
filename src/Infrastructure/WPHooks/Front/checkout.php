<?php
/**
 * WPHooks
 *
 * @package wooenvio/wecorreos
 */

if ( ! wp_doing_ajax() ) {
	add_action( 'wp_enqueue_scripts', $cowc_container->raw( 'enqueue_wecorreos_reload_payment_checkout' ) );
	add_action( 'wp_enqueue_scripts', $cowc_container->raw( 'enqueue_wecorreos_ajax_js_on_front' ) );
	add_action( 'wp_enqueue_scripts', $cowc_container->raw( 'add_style_on_checkout_page' ) );
}
add_action( 'woocommerce_after_shipping_rate', $cowc_container->raw( 'add_free_word_on_none_shipping_cost' ) );
