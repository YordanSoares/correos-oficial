<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Class for validate integer
 */
class Is_Int extends Validator {

	/**
	 * Validate string or array values like integer
	 *
	 * @param mixed $value Value to validate (string/array).
	 * @return bool
	 */
	public function validate( $value ) {
		if ( ! is_array( $value ) ) {
			return $this->is_int( $value );
		}

		foreach ( $value as $sub_value ) {
			if ( ! $this->is_int( $sub_value ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Validate string  like integer
	 *
	 * @param string $value Value to validate.
	 * @return bool
	 */
	private function is_int( $value ) {
		return false === filter_var( $value, FILTER_VALIDATE_INT ) ? false : true;
	}

	/**
	 * Generate error message for not validate integer.
	 *
	 * @param string $text_domain Text domain for translations.
	 * @return string
	 */
	public function generate_error_message( $text_domain ) {
		return __( 'Invalid integer', $text_domain );
	}
}
