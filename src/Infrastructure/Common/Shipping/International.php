<?php // phpcs:ignoreFile
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Shipping;

class International extends AbstractShippingPro {

	public static $configFile = 'config/international.config.php';

	public function getConfig() {
		return include self::$configFile;
	}
}
