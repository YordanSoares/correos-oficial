<?php
/**
 * Sender
 *
 * @package wooenvio/wecorreos/Application/Settings/Sender
 */

namespace WooEnvio\WECorreos\Application\Services\Settings\Senders;

/**
 * Settings Class.
 */
class Update_Senders_Request {

	/**
	 * Senders
	 *
	 * @var array
	 */
	public $senders;

	/**
	 * Setup class.
	 *
	 * @param array $senders Senders.
	 */
	public function __construct( $senders ) {
		$this->senders = $senders;
	}
}
