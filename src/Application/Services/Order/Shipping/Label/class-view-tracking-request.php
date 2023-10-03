<?php
/**
 * Label actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Label
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Label;

/**
 * Class View_Tracking_Request
 */
class View_Tracking_Request {

	/**
	 * Order id
	 *
	 * @var string
	 */
	public $order_id;

	/**
	 * View_Tracking_Request constructor.
	 *
	 * @param string $order_id Order id.
	 */
	public function __construct( $order_id ) {
		$this->order_id = $order_id;
	}
}
