<?php
/**
 * Services
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\WECorreos\Application\Services\Settings\Senders\Update_Senders_Handler;
use WooEnvio\WECorreos\Application\Services\Settings\Senders\Update_Senders_Request;
use WooEnvio\WECorreos\Application\Services\Settings\Senders\Add_Sender_Handler;
use WooEnvio\WECorreos\Application\Services\Settings\Senders\Add_Sender_Request;
use function WooEnvio\WECorreos\Shared\CountrySender\country_options;
use function WooEnvio\WECorreos\Shared\CountrySender\state_options;

$cowc_container['decode_json_data'] = function( $data ) {
	$data = json_decode( wp_unslash( $data ), true );

	$decode_data = [];

	foreach ( $data as $key => $data_sender ) {
		$data_sender['key'] = $key;
		$decode_data[]      = $data_sender;
	}

	return $decode_data;
};

$cowc_container['wecorreos_save_senders'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$update_senders = new Update_Senders_Handler( $c['senders_repository'] );

		$data = call_user_func_array( $c->raw( 'decode_json_data' ), [ $c['request']->get( 'senders' ) ] );

		$update_senders_request = new Update_Senders_Request( $data );

		$senders = $update_senders( $update_senders_request );

		return [
			'success'   => __( 'Data Saved', 'correoswc' ),
			'sanitized' => $senders->data(),
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};

$cowc_container['wecorreos_add_sender'] = function( $c ) {

	$ajax_clousure = function() use ( $c ) {

		$update_senders  = new Add_Sender_Handler( $c['senders_repository'] );
		$sender          = $update_senders( new Add_Sender_Request( $c['request']->get( 'key' ) ) );
		$states_options  = state_options( 'ES', true );
		$country_options = country_options();

		$sender_content = $c['plates']->render( 'settings::sender', compact( 'sender', 'states_options', 'country_options' ) );

		return [
			'add' => [
				'id'      => $c['request']->get( 'add_id' ),
				'content' => $sender_content,
			],
		];
	};

	call_user_func_array( $c->raw( 'ajax_response' ), [ $ajax_clousure ] );
};



