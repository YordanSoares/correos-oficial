<?php
/**
 * Format
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Format;

/**
 * Class Correos_Price
 */
class Correos_Price {

	const EUROS_TO_CENTS = 100;
	const DIGITS         = 6;

	/**
	 * Function
	 *
	 * @param mixed $euros Euros.
	 *
	 * @return string
	 */
	public static function from_euros( $euros ) {
		return str_pad( floor( $euros * static::EUROS_TO_CENTS ), static::DIGITS, '0', STR_PAD_LEFT );
	}
}
