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
class Is_Email extends Validator {

	/**
	 * Validate string or array values like email
	 *
	 * @param mixed $value Value to validate (string/array).
	 * @return bool
	 */
	public function validate( $value ) {
		if ( ! is_array( $value ) ) {
			return $this->is_email( $value );
		}

		foreach ( $value as $sub_value ) {
			if ( ! $this->is_email( $sub_value ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Validate string  like email
	 *
	 * @param string $value Value to validate.
	 * @return bool
	 */
	private function is_email( $value ) {
		return false === filter_var( $value, FILTER_VALIDATE_EMAIL ) ? false : true;
	}

	/**
	 * Generate error message for not validate email.
	 *
	 * @param string $text_domain Text domain for translations.
	 * @return string
	 */
	public function generate_error_message( $text_domain ) {
		return __( 'Invalid email address', $text_domain );
	}
}
