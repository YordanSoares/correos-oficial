<?php
/**
 * Return actions
 *
 * @package wooenvio/wecorreos/Application/Front
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;

/**
 * Class View_Returns_Request
 */
class View_Returns_Request {

	/**
	 * Order
	 *
	 * @var Order
	 */
	public $order;

	/**
	 * View_Returns_Request constructor.
	 *
	 * @param Order $order Order.
	 */
	public function __construct( $order ) {
		$this->order = $order;
	}
}
