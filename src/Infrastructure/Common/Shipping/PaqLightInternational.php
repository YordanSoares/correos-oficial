<?php // phpcs:ignoreFile
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Shipping;

class PaqLightInternational extends AbstractShippingPro {

	public static $configFile = 'config/paqlightinternational.config.php';

	public function getConfig() {
		return include self::$configFile;
	}
}
