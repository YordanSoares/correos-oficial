<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Order;

use WooEnvio\WpPlugin\Files\Pair_Content_File;

/**
 * Class State_Woocommerce_Code
 */
class State_Woocommerce_Code {

	const SEPARATOR       = ':';
	const STATESCODE_FILE = '/wecorreos-state-woocommerce-code.txt';

	/**
	 * From correos state
	 *
	 * @param string $state_name State name.
	 *
	 * @return mixed|string
	 */
	public static function from_correos_state_name( $state_name ) {
		$path = __DIR__ . static::STATESCODE_FILE;

		$states_list = Pair_Content_File::to_array( $path, static::SEPARATOR );

		return isset( $states_list[ $state_name ] ) ? $states_list[ $state_name ] : '';
	}

	/**
	 * From cp
	 *
	 * @param string $cp Postal code.
	 *
	 * @return mixed|string
	 */
	public static function from_cp( $cp ) {

		$code       = substr( $cp, 0, 2 );
		$state_code = State_Correos_Code::options();
		$code_state = array_flip( $state_code );
		return isset( $code_state[ $code ] ) ? $code_state[ $code ] : '';
	}
}
