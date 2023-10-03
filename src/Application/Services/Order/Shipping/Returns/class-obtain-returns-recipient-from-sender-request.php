<?php
/**
 * Return actions
 *
 * @package wooenvio/wecorreos/Application/Front
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns;

/**
 * Class Obtain_Returns_Recipient_From_Sender_Request
 */
class Obtain_Returns_Recipient_From_Sender_Request {

	/**
	 * Sender_key
	 *
	 * @var int
	 */
	public $sender_key;

	/**
	 * Obtain_Returns_Recipient_From_Sender_Request constructor.
	 *
	 * @param int $sender_key Sender key.
	 */
	public function __construct( $sender_key ) {
		$this->sender_key = $sender_key;
	}
}
