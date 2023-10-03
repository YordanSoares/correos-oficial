<?php
/**
 * Format
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Format;

/**
 * Class Correos_Weight
 */
class Correos_Weight {

	const KG_TO_GRAM_CONVERSION = 1000;

	/**
	 * Transform
	 *
	 * @param mixed $weight Weight.
	 *
	 * @return false|string
	 */
	public static function kg_to_grams( $weight ) {
		return (string) intval( floor( $weight * self::KG_TO_GRAM_CONVERSION ));
	}
}
