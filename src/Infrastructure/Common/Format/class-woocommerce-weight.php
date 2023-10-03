<?php
/**
 * Format
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Format;

/**
 * Class Woocommerce_Weight
 */
class Woocommerce_Weight {

	const PRECISION = 3;

	const KG_TO_KG   = 1;
	const GRAM_TO_KG = 0.001;
	const LBS_TO_KG  = 0.45359237;
	const OZ_TO_KG   = 0.0283495;

	const DEFAULT_CONVERSION = 1;

	/**
	 * Transform
	 *
	 * @param mixed  $weight Weight.
	 * @param string $woocommerce_unit Woocommerce unit.
	 *
	 * @return false|float
	 */
	public static function to_kg( $weight, $woocommerce_unit = 'kg' ) {

		$conversion = static::conversion( $woocommerce_unit );

		return round( $weight * $conversion, static::PRECISION );
	}

	/**
	 * Transform
	 *
	 * @param mixed $woocommerce_unit Woocommerce_unit.
	 *
	 * @return int|mixed
	 */
	public static function conversion( $woocommerce_unit ) {

		$conversions = [
			'kg'  => static::KG_TO_KG,
			'g'   => static::GRAM_TO_KG,
			'lbs' => static::LBS_TO_KG,
			'oz'  => static::OZ_TO_KG,
		];

		return isset( $conversions[ $woocommerce_unit ] ) ? $conversions[ $woocommerce_unit ] : static::DEFAULT_CONVERSION;
	}
}
