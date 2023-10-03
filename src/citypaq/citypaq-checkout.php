<?php
/**
 * Citypaq shipping features in checkout
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\Checkout;

use function WooEnvio\WECorreos\Citypaq\Options\citypaq_options_by_cp;
use function WooEnvio\WECorreos\Citypaq\Order\update_address_order_from_citypaq;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByCode\obtain_citypaq_by_code;
use function WooEnvio\WECorreos\Citypaq\States\states_with_citypaqs_options;
use function WooEnvio\WECorreos\Shared\Checkout\is_current_checkout_shipping_a_citypaq_method;
use function WooEnvio\WECorreos\Citypaq\OrderMeta\update_citypaq_code;
use function WooEnvio\WECorreos\Shared\Checkout\selected_checkout_cp;
use const WooEnvio\WECorreos\Citypaq\Options\NONE_CITY_PAQ_SELECTED;
use function WooEnvio\WECorreos\Shared\Template\echo_render;

/**
 * Display citypaq selector in checkout
 */
function display_citypaq_selector_in_checkout() {
	if ( ! is_current_checkout_shipping_a_citypaq_method() ) {
		return;
	}

	$postalcode     = selected_checkout_cp();
	$citypaqs       = citypaq_options_by_cp( $postalcode );
	$states_options = states_with_citypaqs_options();
	echo_render( 'shipping::citypaq-section', compact( 'citypaqs', 'postalcode', 'states_options' ) );
}

/**
 * Update selected citypaq in order after checkout
 *
 * @param int $order_id Order ID.
 */
function update_selected_citypaq_in_checkout( $order_id ) {
	if ( ! is_current_checkout_shipping_a_citypaq_method() ) {
		return;
	}
	update_citypaq_code( $order_id, citypaq_code_in_checkout());
}

/**
 * Citypaq code in checkout
 *
 * @return string
 */
function citypaq_code_in_checkout() {
	return \sanitize_text_field( $_POST['wecorreos-select-citypaq-form']['selected_citypaq'] );
}

/**
 * Validate selected citypaq in order after checkout
 */
function validate_selected_citypaq_in_checkout() {
	if ( ! is_current_checkout_shipping_a_citypaq_method() ) {
		return;
	}

	if ( NONE_CITY_PAQ_SELECTED === citypaq_code_in_checkout() ) {
		wc_add_notice(
			sprintf(
				'<strong>%1$s</strong> %2$s',
				__( 'Select City paq', 'correoswc' ),
				__( 'is required for this shipping method.', 'correoswc' )
			),
			'error'
		);
	}
}

/**
 * Update address order with selected citypaq address after checkout
 *
 * @param \WC_Order $order Order.
 */
function update_address_order_with_citypaq_in_checkout( $order ) {
	if ( ! is_current_checkout_shipping_a_citypaq_method() ) {
		return;
	}

	$citypaq = obtain_citypaq_by_code( citypaq_code_in_checkout());
	update_address_order_from_citypaq( $order, $citypaq );
}
