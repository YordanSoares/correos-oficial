<?php
/**
 * Init hooks for citypaq shipping features
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq;

/**
 * Init hooks
 */
function init() {
	add_action( 'woocommerce_review_order_after_shipping', 'WooEnvio\WECorreos\Citypaq\Checkout\display_citypaq_selector_in_checkout' );
	add_action( 'woocommerce_checkout_process', 'WooEnvio\WECorreos\Citypaq\Checkout\validate_selected_citypaq_in_checkout' );
	add_action( 'woocommerce_checkout_update_order_meta', 'WooEnvio\WECorreos\Citypaq\Checkout\update_selected_citypaq_in_checkout' );
	add_action( 'woocommerce_checkout_create_order', 'WooEnvio\WECorreos\Citypaq\Checkout\update_address_order_with_citypaq_in_checkout' );

	add_action( 'wp_ajax_wecorreos_obtain_citypaqs_by_cp', 'WooEnvio\WECorreos\Citypaq\Ajax\ByCp\ajax_obtain_citypaqs_selector_by_cp' );
	add_action( 'wp_ajax_nopriv_wecorreos_obtain_citypaqs_by_cp', 'WooEnvio\WECorreos\Citypaq\Ajax\ByCp\ajax_obtain_citypaqs_selector_by_cp' );
	add_action( 'wp_ajax_wecorreos_obtain_citypaqs_by_state', 'WooEnvio\WECorreos\Citypaq\Ajax\ByState\ajax_obtain_citypaqs_selector_by_state' );
	add_action( 'wp_ajax_nopriv_wecorreos_obtain_citypaqs_by_state', 'WooEnvio\WECorreos\Citypaq\Ajax\ByState\ajax_obtain_citypaqs_selector_by_state' );
	add_action( 'wp_ajax_wecorreos_obtain_citypaqs_favorites', 'WooEnvio\WECorreos\Citypaq\Ajax\Favorites\ajax_obtain_citypaqs_selector_favorites' );
	add_action( 'wp_ajax_nopriv_wecorreos_obtain_citypaqs_favorites', 'WooEnvio\WECorreos\Citypaq\Ajax\Favorites\ajax_obtain_citypaqs_selector_favorites' );
}
