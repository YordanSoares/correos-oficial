<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Class for validate number value is greater than minimum
 */
class Is_Greater_Than extends Validator {

	/**
	 * Validate string or array values like value is greater than minimum
	 *
	 * @param mixed $value Value to validate (string/array).
	 * @return bool
	 */
	public function validate( $value ) {
		if ( ! is_array( $value ) ) {
			return $this->is_greater_than( $value );
		}

		foreach ( $value as $sub_value ) {
			if ( ! $this->is_greater_than( $sub_value ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Validate string  like value is greater than minimum
	 *
	 * @param string $value Value to validate.
	 * @return bool
	 * @throws \Exception Thrown when minimum value not exists on class (on parent constructor not exists).
	 */
	private function is_greater_than( $value ) {
		if ( ! ( new Is_Float() )->validate( $value ) ) {
			return false;
		}

		if ( ! isset( $this->min ) ) {
			throw new \Exception( 'WooEnvio. Is_Greater_Than validator require param \'min\'' );
		}

		if ( isset( $this->inclusive ) ) {
			return ( $value + 0 ) >= ( $this->min + 0 );
		} else {
			return ( $value + 0 ) > ( $this->min + 0 );
		}

		return strval( floatval( $value ) ) === strval( $value );
	}

	/**
	 * Generate error message for not validate value is greater than minimum.
	 *
	 * @param string $text_domain Text domain for translations.
	 * @return string
	 */
	public function generate_error_message( $text_domain ) {
		if ( isset( $this->inclusive ) ) {
			$error = __( 'must be greater or equal than %1$s', $text_domain );
		} else {
			$error = __( 'must be greater than %1$s', $text_domain );
		}

		return sprintf( $error, $this->min );
	}
}
