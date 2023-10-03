<?php
namespace WooEnvio\WECorreos\Infrastructure\Repositories\WooCommerce;

class Bank_Account_Repository {

	const CORREOS_PAYONDELIVERY = 'we_correos_payondelivery';
	const BANK_ACCOUNT_SETTING  = 'bank_account_number';

	public function obtain() {

		$settings = $this->correos_payondelivery_settings();

		if ( ! isset( $settings[ self::BANK_ACCOUNT_SETTING ] ) ) {
			return '';
		}

		return $settings[ self::BANK_ACCOUNT_SETTING ];
	}

	private function correos_payondelivery_settings() {

		$payments = $this->woocommerce_payments();

		if ( ! isset( $payments[ self::CORREOS_PAYONDELIVERY ] ) ) {
			return [];
		}

		$correos_payondelivery = $payments[ self::CORREOS_PAYONDELIVERY ];

		$correos_payondelivery->init_settings();

		return $correos_payondelivery->settings;
	}

	private function woocommerce_payments() {

		return \WC()->payment_gateways->payment_gateways();
	}
}
