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
class Add_Sender_Request {

	/**
	 * Sender key
	 *
	 * @var string
	 */
	public $key;

	/**
	 * Setup class.
	 *
	 * @param string $key Sender key.
	 */
	public function __construct( $key ) {
		$this->key = $key;
	}
}
