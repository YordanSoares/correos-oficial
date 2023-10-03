<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Class for validate is length string less than maximum
 */
class Is_Length_Less_Than extends Validator {

	/**
	 * Validate string or array values like is length string less than maximum
	 *
	 * @param mixed $value Value to validate (string/array).
	 * @return bool
	 */
	public function validate( $value ) {
		if ( ! is_array( $value ) ) {
			return $this->is_length_less_than( $value );
		}

		foreach ( $value as $sub_value ) {
			if ( ! $this->is_length_less_than( $sub_value ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Validate string  like is length string less than maximum
	 *
	 * @param string $value Value to validate.
	 * @return bool
	 * @throws \Exception Thrown when maximum value not exists on class (on parent constructor not exists).
	 */
	public function is_length_less_than( $value ) {
		if ( ! isset( $this->max ) ) {
			throw new \Exception( 'WooEnvio. Is_Length_Less_Than validator require param \'max\'' );
		}

		$length = strlen( $value );

		if ( isset( $this->inclusive ) ) {
			return ( $length + 0 ) <= ( $this->max + 0 );
		} else {
			return ( $length + 0 ) < ( $this->max + 0 );
		}
	}

	/**
	 * Generate error message for not validate is length string less than maximum.
	 *
	 * @param string $text_domain Text domain for translations.
	 * @return string
	 */
	public function generate_error_message( $text_domain ) {
		if ( isset( $this->inclusive ) ) {
			$error = __( 'string\'s length must be less or equal than %1$s', $text_domain );
		} else {
			$error = __( 'string\'s length must be less than %1$s', $text_domain );
		}

		return sprintf( $error, $this->max );
	}
}
