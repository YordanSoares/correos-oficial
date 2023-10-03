<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Customs;

use WooEnvio\WpPlugin\Files\Pair_Content_File;

/**
 * Class Tariff_Number
 */
class Tariff_Number {

	const SEPARATOR         = ':';
	const DESCRIPTIONS_FILE = '/wecorreos-tariff-number.txt';

	/**
	 * Options.
	 *
	 * @return array
	 */
	public static function options() {
		$path = __DIR__ . static::DESCRIPTIONS_FILE;

		return Pair_Content_File::to_array( $path, static::SEPARATOR );
	}
}
