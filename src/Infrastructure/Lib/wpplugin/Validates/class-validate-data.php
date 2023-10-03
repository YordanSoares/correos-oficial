<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Class for validate Data
 */
class Validate_Data {

	/**
	 * Validation lists
	 *
	 * @var array
	 */
	protected $validations;

	/**
	 * Data to validate
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Validation error lists (not validate data)
	 *
	 * @var array
	 */
	protected $errors = [];

	/**
	 * Text domain for translations
	 *
	 * @var string
	 */
	protected $text_domain;

	/**
	 * Constructor
	 *
	 * @param array  $validations    Validation lists.
	 * @param array  $data           Data to validate.
	 * @param string $text_domain    Text domain for translations.
	 */
	public function __construct( $validations, $data, $text_domain ) {
		$this->validations = $validations;
		$this->data        = $data;
		$this->text_domain = $text_domain;
	}

	/**
	 * Validate Data
	 *
	 * @return bool
	 * @throws Validation_Exception Thrown when there are not validated data.
	 */
	public function validate() {
		$this->run_validations();

		if ( $this->has_errors() ) {
			throw new Validation_Exception( $this->errors );
		}

		return true;
	}

	/**
	 * Run each validate rule and fill errors list (if not validating)
	 */
	private function run_validations() {
		foreach ( $this->validations as $field => $params ) {
			$validate_field = new Validate_Field( $field, $params, $this->text_domain );

			$validate_field->validate( $this->obtain_value_field( $field ) );

			if ( $validate_field->has_errors() ) {
				array_push( $this->errors, $validate_field->error() );
			}
		}
	}

	/**
	 * Extract value of field name from data
	 *
	 * @param string $field  Field name.
	 * @return string
	 * @throws \Exception Thrown when there are not validated data.
	 */
	private function obtain_value_field( $field ) {
		if ( $this->exists_field_on_data( $field ) ) {
			if ( is_object( $this->data ) ) {
				return $this->data->{$field};
			}

			if ( is_array( $this->data ) ) {
				return $this->data[ $field ];
			}
		}

		throw new \Exception(
			sprintf(
				'Field %s to validate not exists on Request',
				$field
			)
		);
	}

	/**
	 * Check if exists data for field
	 *
	 * @param string $field  Field name.
	 * @return bool
	 */
	private function exists_field_on_data( $field ) {
		if ( is_object( $this->data ) ) {
			return isset( $this->data->{$field} );
		}

		if ( is_array( $this->data ) ) {
			return isset( $this->data[ $field ] );
		}

		return false;
	}

	/**
	 * Check if there are any errors
	 *
	 * @return bool
	 */
	private function has_errors() {
		return ! empty( $this->errors );
	}
}
