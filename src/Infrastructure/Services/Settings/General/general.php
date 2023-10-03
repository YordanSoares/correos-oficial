<?php
/**
 * Services
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\WECorreos\Application\Services\Settings\General\Update_General_Handle;
use WooEnvio\WECorreos\Application\Services\Settings\General\Update_General_Request;

$cowc_container['wecorreos_save_general'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$update_general         = new Update_General_Handle( $c['general_repository'] );
		$update_general_request =
			new Update_General_Request(
			$c['request']->get( 'correos_user' ),
			// phpcs:ignore
			str_replace("\\", '', $_POST['correos_password'] ),
			$c['request']->get( 'labeler_code' ),
			$c['request']->get( 'contract_number' ),
			$c['request']->get( 'client_number' ),
			$c['request']->get( 'paq48home' ) === 'true',
			$c['request']->get( 'paq72home' ) === 'true',
			$c['request']->get( 'paq48office' ) === 'true',
			$c['request']->get( 'paq72office' ) === 'true',
			$c['request']->get( 'international' ) === 'true',
			$c['request']->get( 'paqlightinternational' ) === 'true',
			$c['request']->get( 'enabled_sms' ) === 'true',
			$c['request']->get( 'order_status_on_obtain_label' ),
			$c['request']->get( 'paq48citypaq' ) === 'true',
			$c['request']->get( 'googlemap_apikey' ),
			$c['request']->get( 'paq72citypaq' ) === 'true',
			$c['request']->get( 'altsslcom' ) === 'true',
			$c['request']->get( 'enabled_required_id' ) === 'true',
			$c['request']->get( 'enabled_personalised_id' ) === 'true',
			$c['request']->get( 'personalised_id' ),
		);
		$general = $update_general( $update_general_request );

		return [
			'success'   => __( 'Data Saved', 'correoswc' ),
			'sanitized' => $general->data(),
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};

