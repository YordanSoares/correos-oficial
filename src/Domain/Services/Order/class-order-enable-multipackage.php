<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Order;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;

/**
 * Class Order_Enable_Multipackage
 */
class Order_Enable_Multipackage {
	/**
	 * On
	 *
	 * @param Order $order Order.
	 *
	 * @return bool
	 */
	public static function on( $order ) {

		$method = $order->shipping_method_id();

		$enable_multipackage_methods = [
			'paq48home',
			'paq48office',
			'paq72home',
			'paq72office',
		];

		return in_array( $method, $enable_multipackage_methods, true );

	}
}
