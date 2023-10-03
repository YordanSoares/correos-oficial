<?php
/**
 * Init hooks for postoffice shipping features
 *
 * @package wooenvio/wecorreos/postoffice
 */

namespace WooEnvio\WECorreos\Postoffice;

/**
 * Init hooks
 */
function init() {
	add_action( 'woocommerce_review_order_after_shipping', 'WooEnvio\WECorreos\Postoffice\Checkout\display_postoffice_selector_in_checkout' );
	add_action( 'woocommerce_checkout_process', 'WooEnvio\WECorreos\Postoffice\Checkout\validate_selected_postoffice_in_checkout' );
	add_action( 'woocommerce_checkout_update_order_meta', 'WooEnvio\WECorreos\Postoffice\Checkout\update_selected_postoffice_in_checkout' );
	add_action( 'woocommerce_checkout_create_order', 'WooEnvio\WECorreos\Postoffice\Checkout\update_address_order_with_selected_postoffice' );

	add_action( 'wp_ajax_wecorreos_obtain_postoffices_by_cp', 'WooEnvio\WECorreos\Postoffice\Ajax\ajax_obtain_postoffices_by_cp' );
	add_action( 'wp_ajax_nopriv_wecorreos_obtain_postoffices_by_cp', 'WooEnvio\WECorreos\Postoffice\Ajax\ajax_obtain_postoffices_by_cp' );
}
