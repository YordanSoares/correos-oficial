<?php
/**
 * Citypaq shipping features in checkout
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\Order;

use WooEnvio\WECorreos\Domain\Services\Order\State_Woocommerce_Code;

/**
 * Update address order with postoffice
 *
 * @param \WC_Order $order Order.
 * @param array     $postoffice Postoffice data.
 */
function update_address_order_from_postoffice( $order, $postoffice ) {

	$order->set_shipping_address_1( format_postoffice_address( $postoffice));
	$order->set_shipping_address_2( '' );
	$order->set_shipping_city( $postoffice['descLocalidad'] );
	$order->set_shipping_postcode( $postoffice['cp']  );
	$order->set_shipping_state( State_Woocommerce_Code::from_cp( $postoffice['cp'] ));
	$order->set_shipping_country( 'ES');
}

/**
 * Format postoffice address
 *
 * @param array $postoffice Postoffice data.
 * @return string
 */
function format_postoffice_address( $postoffice ) {
	return sprintf(
		'%1$s. %2$s',
		$postoffice['nombre'],
		$postoffice['direccion']
	);
}
