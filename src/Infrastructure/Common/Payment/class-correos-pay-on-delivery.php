<?php
/**
 * Payment
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Payment;

/**
 * Class Correos_Pay_On_Delivery
 *
 * @package WooEnvio\WECorreos\Infrastructure\Common\Payment
 */
class Correos_Pay_On_Delivery extends Payment {

	/**
	 * Config file.
	 *
	 * @var string
	 */
	public static $configFile = 'config/payondelivery.config.php';

	/**
	 * Function.
	 *
	 * @return mixed
	 */
	public function getConfig() {
		return include self::$configFile;
	}

	/**
	 * Function.
	 */
	public function init() {
		parent::init();

		$this->bank_account_number = $this->get_option( 'bank_account_number' );
	}

	/**
	 * Function.
	 */
	public function init_form_fields() {
		parent::init_form_fields();

		$this->form_fields['bank_account_number'] = [
			'title'       => __( 'Bank account number / IBAN', 'correoswc' ),
			'type'        => 'text',
			'description' => __( 'E.g. ES51 2095 0032 8091 0766 7150', 'correoswc' ),
			'default'     => '',
			'desc_tip'    => true,
		];
	}
}
