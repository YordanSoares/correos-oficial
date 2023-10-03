<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Validate Exception
 */
class Validation_Exception extends \Exception {

	/**
	 * Validation error list
	 *
	 * @var array
	 */
	protected $validation_errors = [];

	/**
	 * Construct
	 *
	 * @param string $validation_errors Validation error list.
	 * @param string $code              Exception error code.
	 * @param string $previous          Previous exception.
	 */
	public function __construct( $validation_errors, $code = 0, $previous = null ) {
		$this->validation_errors = $validation_errors;

		parent::__construct( implode( ', ', $validation_errors ), $code, $previous );
	}

	/**
	 * Return validation error list
	 *
	 * @return array
	 */
	public function validation_errors() {
		return $this->validation_errors;
	}
}
