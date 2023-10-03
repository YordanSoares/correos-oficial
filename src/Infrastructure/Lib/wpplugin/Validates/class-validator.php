<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Validor base
 */
abstract class Validator {

	/**
	 * Constructor
	 *
	 * @param array $params Params to validators.
	 */
	public function __construct( $params = [] ) {
		foreach ( $params as $key => $value ) {
			$this->{$key} = $value;
		}
	}

	/**
	 * Validate value
	 *
	 * @param string $value Value to validate.
	 * @return bool
	 */
	abstract public function validate( $value );

	/**
	 * Generate error message for not validate is number less than maximum.
	 *
	 * @param string $text_domain   Text domain for translations.
	 * @return string
	 */
	abstract public function generate_error_message( $text_domain );

	/**
	 * Getter maggic method
	 *
	 * @param string $key Property name.
	 * @return mixed
	 */
	public function __get( $key ) {
		return isset( $this->$key ) ? $this->$key : null;
	}

	/**
	 * Isset maggic method
	 *
	 * @param string $key Property name.
	 * @return bool
	 */
	public function __isset( $key ) {
		return isset( $this->$key );
	}
}
