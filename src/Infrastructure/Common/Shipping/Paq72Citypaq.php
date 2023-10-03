<?php // phpcs:ignoreFile
/**
 * Shipping
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Shipping;

class Paq72Citypaq extends AbstractShippingPro {

	public static $configFile = 'config/paq72citypaq.config.php';

	public function getConfig() {
		return include self::$configFile;
	}
}
