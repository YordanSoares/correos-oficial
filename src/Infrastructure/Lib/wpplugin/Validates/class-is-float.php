<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Class for validate float
 */
class Is_Float extends Validator {

	/**
	 * Validate string or array values like float
	 *
	 * @param mixed $value Value to validate (string/array).
	 * @return bool
	 */
	public function validate( $value ) {
		if ( ! is_array( $value ) ) {
			return $this->is_float( $value );
		}

		foreach ( $value as $sub_value ) {
			if ( ! $this->is_float( $sub_value ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Validate string  like float
	 *
	 * @param string $value Value to validate.
	 * @return bool
	 */
	private function is_float( $value ) {

		if ( ! is_numeric( $value ) ) {
			return false;
		}

		return is_float( $value + 0.0 );
	}

	/**
	 * Generate error message for not validate float.
	 *
	 * @param string $text_domain Text domain for translations.
	 * @return string
	 */
	public function generate_error_message( $text_domain ) {
		return __( 'Invalid float', $text_domain );
	}
}
