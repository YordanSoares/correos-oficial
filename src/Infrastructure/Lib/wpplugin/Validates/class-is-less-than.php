<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Class for validate number value is less than maximum
 */
class Is_Less_Than extends Validator {

	/**
	 * Validate string or array values like is number less than maximum
	 *
	 * @param mixed $value Value to validate (string/array).
	 * @return bool
	 */
	public function validate( $value ) {
		if ( ! is_array( $value ) ) {
			return $this->is_less_than( $value );
		}

		foreach ( $value as $sub_value ) {
			if ( ! $this->is_less_than( $sub_value ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Validate string  like is number less than maximum
	 *
	 * @param string $value Value to validate.
	 * @return bool
	 * @throws \Exception Thrown when maximum value not exists on class (on parent constructor not exists).
	 */
	private function is_less_than( $value ) {
		if ( ! ( new Is_Float() )->validate( $value ) ) {
			return false;
		}

		if ( ! isset( $this->max ) ) {
			throw new \Exception( 'WooEnvio. Is_Less_Than validator require param \'max\'' );
		}

		if ( isset( $this->inclusive ) ) {
			return ( $value + 0 ) <= ( $this->max + 0 );
		} else {
			return ( $value + 0 ) < ( $this->max + 0 );
		}

		return strval( floatval( $value ) ) === strval( $value );
	}

	/**
	 * Generate error message for not validate is number less than maximum.
	 *
	 * @param string $text_domain Text domain for translations.
	 * @return string
	 */
	public function generate_error_message( $text_domain ) {
		if ( isset( $this->inclusive ) ) {
			$error = __( 'must be less or equal than %1$s', $text_domain );
		} else {
			$error = __( 'must be less than %1$s', $text_domain );
		}

		return sprintf( $error, $this->max );
	}
}
