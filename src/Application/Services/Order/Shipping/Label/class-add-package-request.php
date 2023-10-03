<?php
/**
 * Label actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Label
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Label;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;

/**
 * Class Add_Package_Request
 */
class Add_Package_Request {

	/**
	 * Order
	 *
	 * @var Order
	 */
	public $order;
	/**
	 * Packages
	 *
	 * @var array
	 */
	public $packages;

	/**
	 * Add_Package_Request constructor.
	 *
	 * @param Order $order Order.
	 * @param array $packages Packages.
	 */
	public function __construct( $order, $packages ) {
		$this->order    = $order;
		$this->packages = $packages;
	}
}
