<?php
/**
 * Email
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Email;

use WooEnvio\WECorreos\Infrastructure\Common\Files\Returns_Files;

/**
 * Class Wecorreos_Return
 */
class Wecorreos_Return extends Abstract_Email {

	/**
	 * Config file.
	 *
	 * @var string
	 */
	public static $config_file = 'config/return.config.php';

	/**
	 * Function
	 *
	 * @return mixed
	 */
	public function get_config() {
		return include self::$config_file;
	}

	/**
	 * Function
	 *
	 * @return array
	 */
	public function get_attachments() {
		$return_label_file = ( new Returns_Files( 'wecorreos' ) )->file_path( $this->order_id );

		return [
			$return_label_file,
		];
	}
}
