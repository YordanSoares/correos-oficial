<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Class for validate required
 */
class Is_Required extends Validator {

	/**
	 * Validate string or array values like required
	 *
	 * @param mixed $value Value to validate (string/array).
	 * @return bool
	 */
	public function validate( $value ) {
		if ( ! is_array( $value ) ) {
			return ! empty( $value );
		}

		foreach ( $value as $sub_value ) {
			if ( empty( $sub_value ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Generate error message for not validate required.
	 *
	 * @param string $text_domain Text domain for translations.
	 * @return string
	 */
	public function generate_error_message( $text_domain ) {
		return __( 'is required', $text_domain );
	}
}
