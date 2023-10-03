<?php
/**
 * Postoffice shipping features in checkout
 *
 * @package wooenvio/wecorreos/postoffice
 */

namespace WooEnvio\WECorreos\Postoffice\Checkout;

use function WooEnvio\WECorreos\Citypaq\Order\update_address_order_from_postoffice;
use function WooEnvio\WECorreos\Postoffice\Options\postoffice_options_by_cp;
use function WooEnvio\WECorreos\Postoffice\WebService\obtain_postoffice_by_code;
use function WooEnvio\WECorreos\Shared\Checkout\is_current_checkout_shipping_a_postoffice_method;
use function WooEnvio\WECorreos\Postoffice\OrderMeta\update_postoffice_code;
use function WooEnvio\WECorreos\Shared\Checkout\selected_checkout_cp;
use function WooEnvio\WECorreos\Shared\Template\echo_render;
use const WooEnvio\WECorreos\Postoffice\Options\NONE_POSTOFFICE_SELECTED;

/**
 * Display postoffice selector in checkout
 */
function display_postoffice_selector_in_checkout() {
	if ( ! is_current_checkout_shipping_a_postoffice_method() ) {
		return;
	}
	$postalcode  = selected_checkout_cp();
	$postoffices = postoffice_options_by_cp( $postalcode );
	echo_render( 'shipping::postoffice-section', compact( 'postalcode', 'postoffices'));
}

/**
 * Update selected postoffice in order after checkout
 *
 * @param int $order_id Order ID.
 */
function update_selected_postoffice_in_checkout( $order_id ) {
	if ( ! is_current_checkout_shipping_a_postoffice_method() ) {
		return;
	}
	update_postoffice_code( $order_id, postoffice_code_in_checkout());
}

/**
 * Postoffice code in checkout
 *
 * @return string
 */
function postoffice_code_in_checkout() {
	return \sanitize_text_field( $_POST['wecorreos-select-office-form']['selected_office'] );
}

/**
 * Validate selected postoffice in order after checkout
 */
function validate_selected_postoffice_in_checkout() {
	if ( ! is_current_checkout_shipping_a_postoffice_method() ) {
		return;
	}

	if ( NONE_POSTOFFICE_SELECTED === postoffice_code_in_checkout() ) {
		wc_add_notice(
			sprintf(
				'<strong>%1$s</strong> %2$s',
				__( 'Select a Office', 'correoswc' ),
				__( 'is required for this shipping method.', 'correoswc' )
			),
			'error'
		);
	}
}

/**
 * Update address order with selected postoffice address after checkout
 *
 * @param \WC_Order $order Order.
 */
function update_address_order_with_selected_postoffice( $order ) {
	if ( ! is_current_checkout_shipping_a_postoffice_method() ) {
		return;
	}

	$postoffice = obtain_postoffice_by_code( postoffice_code_in_checkout() );
	update_address_order_from_postoffice( $order, $postoffice );
}
