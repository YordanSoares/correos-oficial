<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Class for validate pattern
 */
class Is_Pattern extends Validator {

	/**
	 * Validate string or array values like pattern
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
	 * Validate string  like pattern
	 *
	 * @param string $value Value to validate.
	 * @return bool
	 */
	private function is_float( $value ) {
		$result = preg_match( $this->pattern, $value );
		return 1 === $result ? true : false;
	}

	/**
	 * Generate error message for not validate pattern.
	 *
	 * @param string $text_domain Text domain for translations.
	 * @return string
	 */
	public function generate_error_message( $text_domain ) {
		return isset( $this->error ) ? $this->error : __( 'Format not valid', $text_domain );
	}
}
