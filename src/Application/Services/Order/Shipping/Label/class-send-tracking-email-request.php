<?php
/**
 * Label actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Label
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Label;

/**
 * Class Send_Tracking_Email_Request
 */
class Send_Tracking_Email_Request {

	/**
	 * Order id
	 *
	 * @var string
	 */
	public $order_id;
	/**
	 * Correos id
	 *
	 * @var string
	 */
	public $correos_id;

	/**
	 * Send_Tracking_Email_Request constructor.
	 *
	 * @param string $order_id Order id.
	 * @param string $correos_id Correos id.
	 */
	public function __construct( $order_id, $correos_id ) {
		$this->order_id   = $order_id;
		$this->correos_id = $correos_id;
	}
}
