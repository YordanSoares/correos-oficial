<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Model/Settings
 */

namespace WooEnvio\WECorreos\Domain\Model\Settings;

use WooEnvio\WpPlugin\Validates\Validate_Data;

/**
 * Class Customs
 */
class Customs {

	/**
	 * Customs_default_description
	 *
	 * @var string
	 */
	private $customs_default_description;
	public $customs_tariff_number;
	public $customs_check_description_and_tariff;
	public $customs_tariff_description;
	public $customs_consignor_reference;   
	/**
	 * Customs constructor.
	 *
	 * @param string $customs_default_description Customs_default_description.
	 */
	public function __construct( $customs_default_description, 
	                             $customs_tariff_number='',
								 $customs_check_description_and_tariff='',
								 $customs_tariff_description='',
								 $customs_consignor_reference='' ) {
		$this->customs_default_description = $customs_default_description;
		$this->customs_tariff_number = $customs_tariff_number;
		$this->customs_check_description_and_tariff = $customs_check_description_and_tariff;
		$this->customs_tariff_description = $customs_tariff_description;
		$this->customs_consignor_reference = $customs_consignor_reference;
	}

	/**
	 * Customs_default_description
	 *
	 * @return string
	 */
	public function customs_default_description() {
		return $this->customs_default_description;
	}

	/**
	 * Tariff number default
	 *
	 * @return string
	 */
	public function customs_tariff_number() {
		return $this->customs_tariff_number;
	}

	/**
	 * Tariff number default
	 *
	 * @return string
	 */
	public function customs_check_description_and_tariff() {
		return $this->customs_check_description_and_tariff;
	}

	/**
	 * Tariff number default
	 *
	 * @return string
	 */
	public function customs_tariff_description() {
		return $this->customs_tariff_description;
	}
	
	/**
	 * Tariff number default
	 *
	 * @return string
	 */
	public function customs_consignor_reference() {
		return $this->customs_consignor_reference;
	}		

	/**
	 * Data
	 *
	 * @return string[]
	 */
	public function data() {
		return [
			'customs_default_description' =>  $this->customs_default_description,
		];
	}

	/**
	 * Build default
	 *
	 * @return static
	 */
	public static function build_default() {
		return new static( '' );
	}

	/**
	 * Build and validate
	 *
	 * @param string $customs_default_description string.
	 *
	 * @return static
	 */
	public static function build_and_validate( $customs_default_description, $customs_tariff_number,
										  $customs_check_description_and_tariff,
	                                      $customs_tariff_description,
	                                      $customs_consignor_reference) {
		$general = new static( $customs_default_description, $customs_tariff_number,
		                       $customs_check_description_and_tariff,
		                       $customs_tariff_description,
		                       $customs_consignor_reference
	);
		$general->validate_or_fail();
		return $general;
	}

	/**
	 * Validation
	 *
	 * @throws \WooEnvio\WpPlugin\Validates\Validation_Exception Fail validation.
	 */
	protected function validate_or_fail() {
		( new Validate_Data( $this->rules(), $this->data(), 'correoswc' ) )->validate();
	}

	/**
	 * Rules
	 *
	 * @return array[]
	 */
	private function rules() {
		return [
			'customs_default_description' => [
				'name'  => __( 'Default description', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
		];
	}
}
