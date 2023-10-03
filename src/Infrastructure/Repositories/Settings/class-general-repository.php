<?php
namespace WooEnvio\WECorreos\Infrastructure\Repositories\Settings;

use WooEnvio\WpPlugin\Repositories\Options_Repository;
use WooEnvio\WECorreos\Domain\Model\Settings\General;
use WooEnvio\WECorreos\Domain\Model\Settings\Shipping\Shipping_List;
use WooEnvio\WECorreos\Infrastructure\Common\Data\General_Data_Transform;

class General_Repository extends Options_Repository {

	const SUFFIX_OPTION_NAME = 'settings_general';

	public function __construct( $slug ) {
		parent::__construct( $slug, self::SUFFIX_OPTION_NAME );
	}

	public function obtain() {
		$data = $this->get();

		if ( empty( $data ) ) {
			return null;
		}

		$data = ( new General_Data_Transform() )->to_after_240( $data );

		$general = new General(
			$data['correos_user'],
			$data['correos_password'],
			$data['labeler_code'],
			$data['contract_number'],
			$data['client_number'],
			$this->obtain_shippings( $data ),
			isset( $data['enabled_sms'] ) ? $data['enabled_sms'] : false,
			isset( $data['order_status_on_obtain_label'] ) ? $data['order_status_on_obtain_label'] : General::NO_CHANGE_ORDER_STATUS,
			isset( $data['googlemap_apikey'] ) ? $data['googlemap_apikey'] : '',
			isset( $data['altsslcom'] ) ? $data['altsslcom'] : false,
			isset( $data['enabled_required_id'] ) ? $data['enabled_required_id'] : false,
			isset( $data['enabled_personalised_id'] ) ? $data['enabled_personalised_id'] : false,
			isset( $data['personalised_id'] ) ? $data['personalised_id'] : false
		);

		return $general;
	}

	public function persist( $general ) {
		$this->save( $general->data() );
	}

	private function obtain_shippings( $data ) {
		return new Shipping_List(
			isset( $data['paq48home'] ) && $data['paq48home'],
			isset( $data['paq72home'] ) && $data['paq72home'],
			isset( $data['paq48office'] ) && $data['paq48office'],
			isset( $data['paq72office'] ) && $data['paq72office'],
			isset( $data['international'] ) && $data['international'],
			isset( $data['paqlightinternational'] ) && $data['paqlightinternational'],
			isset( $data['paq48citypaq'] ) ? $data['paq48citypaq'] : false,
			isset( $data['paq72citypaq'] ) ? $data['paq72citypaq'] : false
		);
	}
}
