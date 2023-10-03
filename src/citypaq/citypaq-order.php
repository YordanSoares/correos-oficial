<?php
/**
 * Citypaq shipping features in order
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\Order;

use WooEnvio\WECorreos\Domain\Services\Order\State_Woocommerce_Code;

/**
 * Update address order with citypaq
 *
 * @param \WC_Order $order Order.
 * @param array     $citypaq Citpaq data.
 */
function update_address_order_from_citypaq( $order, $citypaq ) {

	$order->set_shipping_address_1( build_address( $citypaq) );
	$order->set_shipping_address_2( '' );
	$order->set_shipping_city( $citypaq['city'] );
	$order->set_shipping_postcode( $citypaq['postalCode']  );
	$order->set_shipping_state( State_Woocommerce_Code::from_cp( $citypaq['postalCode'] ));
	$order->set_shipping_country( 'ES' );
}

/**
 * Build address with citypaq
 *
 * @param array $citypaq Citpaq data.
 * @return string
 */
function build_address( $citypaq ) {
	return sprintf('%s %s %s',
		$citypaq['alias'],
		$citypaq['streetType'],
		$citypaq['address']
	);
}
