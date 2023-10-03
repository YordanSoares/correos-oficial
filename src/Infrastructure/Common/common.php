<?php //phpcs:ignoreFile
/**
 * Common functions
 *
 * @package wooenvio/wecorreos/common
 */

require_once __DIR__ . '/Shipping/shippings.php';
require_once __DIR__ . '/Payment/payments.php';
require_once __DIR__ . '/Email/email.php';

/**
 * @author A649437
 * Evolutivo DNI Obligatorio y Aduanas 
 * 5/10/2021
 * Incluye el campo NIF en el email de notificación del cliente
 */
require_once __DIR__ . '/Shipping/DniRequired.php';

use League\Plates\Engine;
use WooEnvio\WpPlugin\Common\Request;
use WooEnvio\WpPlugin\Enqueue\Script;
use WooEnvio\WpPlugin\Enqueue\Style;
use WooEnvio\ClientLicense\Action\Activate_License;
use WooEnvio\ClientLicense\Action\Deactivate_License;
use WooEnvio\ClientLicense\Action\Check_License;
use WooEnvio\WECorreos\Infrastructure\Common\Files\Label_Files;
use WooEnvio\WECorreos\Infrastructure\Common\Files\Merged_Label_Files;
use WooEnvio\ClientCorreos\Soap_Exception;

$cowc_container['request'] = function() {
	return Request::create_from_globals( 'sanitize_text_field' );
};

$cowc_container['images_url'] = function( $c ) {
	return $c['plugin_url'] . 'src/Infrastructure/Web/Assets/img/';
};

$cowc_container['script_handler'] = function( $c ) {
	$script_path = $c['plugin_url'] . 'src/Infrastructure/Web/Assets/js/';
	return new Script( $c['slug'], $script_path, true );
};

$cowc_container['style_handler'] = function( $c ) {
	$script_path = $c['plugin_url'] . 'src/Infrastructure/Web/Assets/css/';
	return new Style( $c['slug'], $script_path, true );
};

$cowc_container['plates'] = function() {

	$plates_engine = new Engine( __DIR__ . '/../Web/Templates', 'php' );
	$plates_engine->addFolder( 'settings', __DIR__ . '/../Web/Templates/Settings' );
	$plates_engine->addFolder( 'costrules', __DIR__ . '/../Web/Templates/CostRules' );
	$plates_engine->addFolder( 'order', __DIR__ . '/../Web/Templates/Order' );
	$plates_engine->addFolder( 'shipping', __DIR__ . '/../Web/Templates/Shipping');
	$plates_engine->addFolder( 'bulkactions', __DIR__ . '/../Web/Templates/Bulk/Actions' );
	$plates_engine->addFolder( 'bulkmessages', __DIR__ . '/../Web/Templates/Bulk/Messages' );
	$plates_engine->addFolder( 'bulkmodal', __DIR__ . '/../Web/Templates/Bulk/Modal' );
	$plates_engine->addFolder( 'welcome', __DIR__ . '/../Web/Templates/Welcome' );

	return $plates_engine;
};

$cowc_container['view_error_wrapper'] = function( $service ) use ( $cowc_container ) {

	try {
		call_user_func_array( $service, [] );
	} catch ( \Exception $e ) {

		$logger = wc_get_logger();

		$logger->error( $e->getMessage(), [ 'source' => 'correoswc' ] );

		echo $cowc_container['plates']->render(
			'error', [
				'error'        => $e->getMessage(),
				'link_support' => $cowc_container['we_support'],
			]
		);
	}
};

$cowc_container['ajax_response'] = function( $service ) {

	if ( ! check_ajax_referer( 'nonce', 'nonce', false ) ) {
		http_response_code( 200 );
		echo wp_send_json( [ 'error' => 'Operation not allowed' ] );
		die();
	}

	try {
		$data = call_user_func_array( $service, [] );
	} catch ( Soap_Exception $e ) {

		$logger = wc_get_logger();

		$logger->error( $e->getMessage(), [ 'source' => 'correoswc' ] );

		$data = [
			'error' => $e->getMessage(),
		];
	} catch ( \Exception $e ) {

		$data = [
			'error' => $e->getMessage(),
		];
	}

	http_response_code( 200 );
	echo wp_send_json( $data );
	die();
};

$cowc_container['label_files'] = function( $c ) {
	return new Label_Files( $c['slug'] );
};

$cowc_container['merged_label_files'] = function( $c ) {
	return new Merged_Label_Files( $c['slug'] );
};
