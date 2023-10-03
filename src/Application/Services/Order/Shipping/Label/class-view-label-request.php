<?php
/**
 * Label actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Label
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Label;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;

/**
 * Class View_Label_Request
 */
class View_Label_Request {
	/**
	 * Order
	 *
	 * @var Order
	 */
	public $order;

	/**
	 * View_Label_Request constructor.
	 *
	 * @param Order $order Order.
	 */
	public function __construct( $order ) {
		$this->order = $order;
	}
}
