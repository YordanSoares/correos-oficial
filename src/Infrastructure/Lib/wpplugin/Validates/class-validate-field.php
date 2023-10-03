<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Class for validate Field
 */
class Validate_Field {

	/**
	 * Field
	 *
	 * @var string
	 */
	protected $field;

	/**
	 * Field Name showing to client
	 *
	 * @var string
	 */
	protected $field_name;

	/**
	 * Rules
	 *
	 * @var array
	 */
	protected $rules;

	/**
	 * Subfields. If main field has more fields
	 *
	 * @var array
	 */
	protected $sub_fields;

	/**
	 * Params to validator
	 *
	 * @var array
	 */
	protected $params;

	/**
	 * Error list on validations
	 *
	 * @var array
	 */
	protected $errors = [];

	/**
	 * Text domain for translations.
	 *
	 * @var string
	 */
	protected $text_domain;

	/**
	 * Contruct
	 *
	 * @param array  $field          Field.
	 * @param array  $params         Params to validators.
	 * @param string $text_domain   Text domain for translations.
	 */
	public function __construct( $field, $params, $text_domain ) {
		$this->field       = $field;
		$this->field_name  = $params['name'];
		$this->rules       = $this->rules( $params );
		$this->sub_fields  = $this->sub_fields( $params );
		$this->params      = $params;
		$this->text_domain = $text_domain;
	}

	/**
	 * Validate value
	 *
	 * @param string $value Value to validate.
	 */
	public function validate( $value ) {
		if ( empty( $this->rules ) && ! empty( $this->sub_fields ) ) {
			array_map(
				function ( $sub_field ) use ( $value ) {

					$validate_sub_field = new Validate_Field( $sub_field, $this->params[ $sub_field ], $this->text_domain );
					$validate_sub_field->validate( $value[ $sub_field ] );

					if ( $validate_sub_field->has_errors() ) {
						array_push( $this->errors, $validate_sub_field->error() );
					}
				}, $this->sub_fields
			);
		}

		array_map(
			function ( $rule ) use ( $value ) {

				if ( ! $rule->validate( $value ) ) {
					array_push( $this->errors, $rule->generate_error_message( $this->text_domain ) );
				};
			}, $this->rules
		);
	}

	/**
	 * Check if there are any errors
	 *
	 * @return bool
	 */
	public function has_errors() {
		return ! empty( $this->errors );
	}

	/**
	 * Build error message with error list
	 *
	 * @return string
	 */
	public function error() {
		 $last_error = count( $this->errors ) > 1 ? ' ' . __( 'and', $this->text_domain ) . ' ' . array_pop( $this->errors ) : '';

		return sprintf(
			'<strong>%s</strong> %s',
			$this->field_name,
			implode( ', ', $this->errors ) . $last_error
		);
	}

	/**
	 * Build rules from params
	 *
	 * @param string $params Params to validators.
	 * @return array
	 * @author Pedro Pinto
	 */
	private function rules( $params ) {
		$raw_rules = isset( $params['rules'] ) ? $params['rules'] : [];

		$rules = [];

		array_walk(
			$raw_rules, function ( $value, $key ) use ( &$rules ) {

				$rule_name = is_array( $value ) ? $key : $value;

				$rule_params = is_array( $value ) ? $value : [];

				$rule_class = $this->rule_class( $rule_name );

				$rules[ $rule_name ] = new $rule_class( $rule_params );
			}
		);

		return $rules;
	}

	/**
	 * Obtain class rule from rule name
	 *
	 * @param string $rule_name Rule name for validator.
	 * @return use WooEnvio\WpPlugin\Validates\Validator
	 * @throws \Exception Thrown when there are not class validator.
	 */
	private function rule_class( $rule_name ) {
		$rule_class = 'WooEnvio\\WpPlugin\\Validates\\' . $rule_name;

		if ( ! class_exists( $rule_class ) ) {
			throw new \Exception(
				sprintf( 'Validation rule %s not exists.', $rule_name )
			);
		}

		return $rule_class;
	}

	/**
	 * Return subfields if exists
	 *
	 * @param string $params Params to validators.
	 * @return array
	 */
	private function sub_fields( $params ) {
		$no_sub_fields = [ 'rules', 'name' ];

		return array_diff( array_keys( $params ), $no_sub_fields );
	}
}
