<?php
/**
 * Email
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Email;

/**
 * Class Wecorreos_Tracking_Deliverer
 */
class Wecorreos_Tracking_Deliverer {

	/**
	 * Send email
	 *
	 * @param mixed $email_action Email_action.
	 * @param mixed $order_id Order_id.
	 * @param mixed $correos_id Correos_id.
	 */
	public function send( $email_action, $order_id, $correos_id ) {
		do_action( $email_action, $order_id, $correos_id );
	}
}
