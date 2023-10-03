<?php // phpcs:ignoreFile
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Shipping;

class Paq48Home extends AbstractShippingPro {

	public static $configFile = 'config/paq48home.config.php';

	public function getConfig() {
		return include self::$configFile;
	}
}
