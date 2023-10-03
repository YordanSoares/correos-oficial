<?php
namespace WooEnvio\WECorreos\Infrastructure\Repositories\Settings;

use WooEnvio\WpPlugin\Repositories\Options_Repository;
use WooEnvio\WECorreos\Domain\Model\Settings\Customs;

class Customs_Repository extends Options_Repository {

	const SUFFIX_OPTION_NAME = 'settings_customs';
	const SUFFIX_OPTION_NAME_TARIFF='tariff_number';

	public function __construct( $slug ) {
		parent::__construct( $slug, self::SUFFIX_OPTION_NAME );
	}

	public function obtain() {
		$data = $this->get();

		if ( empty( $data ) ) {
			return null;
		}
           
		/** Lectura desde la base de datos */
		$data['customs_tariff_number']=get_option('wecorreos_customs_tariff_number');
		$data['customs_check_description_and_tariff']=get_option('wecorreos_customs_check_description_and_tariff');
		$data['customs_tariff_description']=get_option('wecorreos_customs_tariff_description');
		$data['customs_consignor_reference']=get_option('wecorreos_customs_consignor_reference');
		return new Customs( $data['customs_default_description'], 
		                    $data['customs_tariff_number'],
							$data['customs_check_description_and_tariff'], 
							$data['customs_tariff_description'],
		                    $data['customs_consignor_reference']
	  );
	}

	public function persist( $customs ) {
		$this->save( $customs->data() );
	}

	/** Guardado en la base de datos */
	public function persist_customs_data($customs_tariff_number,
										  $customs_check_description_and_tariff,
	                                      $customs_tariff_description,
	                                      $customs_consignor_reference
	){
		update_option('wecorreos_customs_tariff_number', $customs_tariff_number);
		update_option('wecorreos_customs_check_description_and_tariff', $customs_check_description_and_tariff);
		update_option('wecorreos_customs_tariff_description', $customs_tariff_description);
		update_option('wecorreos_customs_consignor_reference', $customs_consignor_reference);
	}
}
