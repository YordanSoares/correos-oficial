<?php
/**
 * Customs
 *
 * @package wooenvio/wecorreos/Application/Settings/Customs
 */

namespace WooEnvio\WECorreos\Application\Services\Settings\Customs;

/**
 * Settings Class.
 */
class Update_Customs_Request {

	/**
	 * Default description.
	 *
	 * @var string
	 */
	public $customs_default_description;
	public $customs_tariff_number;
	public $customs_check_description_and_tariff;
	public $customs_tariff_description;
	public $customs_consignor_reference;

	/**
	 * Setup class.
	 *
	 * @param string $customs_default_description Default description.
	 */
	public function __construct( $customs_default_description, 
	                             $customs_tariff_number,
                          	     $customs_check_description_and_tariff,
								 $customs_tariff_description,
								 $customs_consignor_reference) 
	{
		$this->customs_default_description = $customs_default_description;
		$this->customs_tariff_number = $customs_tariff_number;
		$this->customs_check_description_and_tariff = $customs_check_description_and_tariff;
		$this->customs_tariff_description = $customs_tariff_description;
		$this->customs_consignor_reference = $customs_consignor_reference;				
	}
}
