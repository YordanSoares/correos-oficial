<?php
namespace WooEnvio\WECorreos\Infrastructure\Repositories\WooCommerce;

class Email_Configuration_Repository {

	const PREFIX        = 'woocommerce_';
	const SUFFIX        = '_settings';
	const ENABLED_FIELD = 'enabled';
	const ENABLED_VALUE = 'yes';

	public function enabled( $email ) {

		$settings = $this->obtain( $email );

		if ( ! $settings ) {
			return null;
		}

		return self::ENABLED_VALUE === $settings[ self::ENABLED_FIELD ];
	}

	private function obtain( $email ) {
		return get_option( $this->option( $email ) );
	}

	private function option( $email ) {

		return sprintf(
			'%s%s%s',
			self::PREFIX,
			$email,
			self::SUFFIX
		);
	}
}
