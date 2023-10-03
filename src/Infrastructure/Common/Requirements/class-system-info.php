<?php
/**
 * Requirements
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Requirements;

/**
 * Class System_Info
 */
class System_Info {

	/**
	 * WooCommerce version
	 *
	 * @return string
	 */
	public static function woocommerce_version() {

		if ( class_exists( 'WooCommerce' ) ) {
			global $woocommerce;
			return $woocommerce->version;
		}
		return '1.0';
	}

	/**
	 * PHP version
	 *
	 * @return string
	 */
	public function php_version() {
		return phpversion();
	}
}
