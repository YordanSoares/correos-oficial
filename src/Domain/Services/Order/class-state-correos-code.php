<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Order;

use WooEnvio\WpPlugin\Files\Pair_Content_File;

/**
 * Class State_Correos_Code
 */
class State_Correos_Code {

	const SEPARATOR       = ':';
	const STATESCODE_FILE = '/wecorreos-state-correos-code.txt';

	/**
	 * Options
	 *
	 * @return array
	 */
	public static function options() {
		$path = __DIR__ . static::STATESCODE_FILE;

		return Pair_Content_File::to_array( $path, static::SEPARATOR );
	}
}
