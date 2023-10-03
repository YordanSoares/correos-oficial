<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Class for validate email
 */
class Is_Dni extends Validator {

	/**
	 * Validate string or array values like dni
	 *
	 * @param mixed $value Value to validate (string/array).
	 * @return bool
	 */
	public function validate( $value ) {
		if ( ! is_array( $value ) ) {
			return $this->is_dni( $value );
		}

		foreach ( $value as $sub_value ) {
			if ( ! $this->is_dni( $sub_value ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Validate string  like dni
	 *
	 * @param string $value Value to validate.
	 * @return bool
	 */
	private function is_dni( $value ) {
		return false === filter_var( $value, FILTER_VALIDATE_DNI ) ? false : true;
	}

	/**
	 * Generate error message for not validate dni.
	 *
	 * @param string $text_domain Text domain for translations.
	 * @return string
	 */
	public function generate_error_message( $text_domain ) {
		return __( 'Invalid dni address', $text_domain );
	}
}
