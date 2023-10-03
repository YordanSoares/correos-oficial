<?php
/**
 * Return actions
 *
 * @package wooenvio/wecorreos/Application/Front
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns;

/**
 * Class Send_Returns_Email_Request
 */
class Send_Returns_Email_Request {

	/**
	 * Order id
	 *
	 * @var string
	 */
	public $order_id;
	/**
	 * REturn id
	 *
	 * @var string
	 */
	public $returns_id;

	/**
	 * Send_Returns_Email_Request constructor.
	 *
	 * @param string $order_id Order id.
	 * @param string $returns_id Return id.
	 */
	public function __construct( $order_id, $returns_id ) {
		$this->order_id   = $order_id;
		$this->returns_id = $returns_id;
	}
}
