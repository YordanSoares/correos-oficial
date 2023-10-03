<?php
/**
 * Shared checkout functions
 *
 * @package wooenvio/wecorreos/shared
 */

namespace WooEnvio\WECorreos\Shared\Checkout;

/**
 * Check if current checkout shipping is a citypaq shipping
 *
 * @return bool
 */
function is_current_checkout_shipping_a_citypaq_method() {
	return is_citypaq_shipping( current_checkout_shipping_method());
}

/**
 * Check it is a citypaq shipping
 *
 * @param string $shipping Shipping ID.
 * @return bool
 */
function is_citypaq_shipping( $shipping ) {
	$citypaq_shippings = [ 'paq48citypaq', 'paq72citypaq' ];
	return in_array( $shipping, $citypaq_shippings, true );
}


/**
 * Check if current checkout shipping is a postoffice shipping
 *
 * @return bool
 */
function is_current_checkout_shipping_a_postoffice_method() {
	return is_postoffice_shipping( current_checkout_shipping_method());
}

/**
 * Check it is a postoffice shipping
 *
 * @param string $shipping Shipping ID.
 * @return bool
 */
function is_postoffice_shipping( $shipping ) {
	$postoffice_shippings = [ 'paq48office', 'paq72office' ];
	return in_array( $shipping, $postoffice_shippings, true );
}

/**
 * Return current checkout shipping
 *
 * @return string
 */
function current_checkout_shipping_method() {
	$shipping_methods = array_map( function ( $method ) {
		return current( explode( ':', $method ) );
	}, \WC()->session->get( 'chosen_shipping_methods', [] ) );

	return isset( $shipping_methods[0] ) ? $shipping_methods[0] : '';
}

/**
 * Return current checkout postal code
 *
 * @return string
 */
function selected_checkout_cp() {
	return isset( $_POST['postcode'] ) ? \sanitize_text_field( $_POST['postcode'] ) : '';
}
