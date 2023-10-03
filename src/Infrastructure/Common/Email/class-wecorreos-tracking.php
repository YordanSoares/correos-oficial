<?php
/**
 * Email
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Email;

/**
 * Class Wecorreos_Tracking
 */
class Wecorreos_Tracking extends Abstract_Email {

	/**
	 * Config file
	 *
	 * @var string
	 */
	public static $config_file = 'config/tracking.config.php';

	/**
	 * Function
	 *
	 * @return mixed
	 */
	public function get_config() {
		return include self::$config_file;
	}
}
