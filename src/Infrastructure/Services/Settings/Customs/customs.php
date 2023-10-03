<?php
/**
 * Services
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\WECorreos\Application\Services\Settings\Customs\Update_Customs_Handler;
use WooEnvio\WECorreos\Application\Services\Settings\Customs\Update_Customs_Request;

$cowc_container['wecorreos_save_customs'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$update_customs = new Update_Customs_Handler( $c['customs_repository'] );

		$update_customs_request = new Update_Customs_Request(
			$c['request']->get( 'customs_default_description'),
			$c['request']->get( 'customs_tariff_number'),
			$c['request']->get( 'customs_check_description_and_tariff'),
			$c['request']->get( 'customs_tariff_description'),
			$c['request']->get( 'customs_consignor_reference')
		);

		$customs = $update_customs( $update_customs_request );

		return [
			'success'   => __( 'Data Saved', 'correoswc' ),
			'sanitized' => $customs->data()
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};

