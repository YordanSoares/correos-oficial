<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Order;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;

/**
 * Class Order_Enable_Request_Declaration
 */
class Order_Enable_Request_Declaration {

	/**
	 * On
	 *
	 * @param Order $order Order.
	 *
	 * @return bool
	 */
	public static function on( $order ) {

		$method = $order->shipping_method_id();

		$enable_request_declaration_methods = [
			'international',
			'paqlightinternational',
			'paq48home',
			'paq72home',
			'paq48office',
			'paq72office',
			'paq48citipaq',
			'paq72citypaq'
		];

		return in_array( $method, $enable_request_declaration_methods, true );
	}
}
