<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Order;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;

/**
 * Class Order_Enable_Returns
 */
class Order_Enable_Returns {

	/**
	 * On
	 *
	 * @param Order $order Order.
	 *
	 * @return bool
	 */
	public function on( $order ) {
		$method = $order->shipping_method_id();

		$enable_returns_methods = [
			'paq48correospaq',
			'paq48home',
			'paq48office',
			'paq72correospaq',
			'paq72home',
			'paq72office',
		];

		return in_array( $method, $enable_returns_methods, true );
	}
}
