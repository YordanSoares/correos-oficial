<?php
/**
 * Email
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Email;

/**
 * Class Wecorreos_Return_Deliverer
 */
class Wecorreos_Return_Deliverer {

	/**
	 * Send email
	 *
	 * @param mixed $email_action Email_action.
	 * @param mixed $order_id Order_id.
	 * @param mixed $returns_id Returns_id.
	 */
	public function send( $email_action, $order_id, $returns_id ) {
		do_action( $email_action, $order_id, $returns_id );
	}
}
