<?php
/**
 * Shared ajax functions
 *
 * @package wooenvio/wecorreos/shared
 */

namespace WooEnvio\WECorreos\Shared\Ajax;

use WooEnvio\ClientCorreos\Soap_Exception;

/**
 * Wrap callable actions. Check nonce security and defend from exception. Log exceptions.
 *
 * @param callable $action callable item to execute it.
 */
function ajax_response( $action ) {

	if ( ! check_ajax_referer( 'nonce', 'nonce', false ) ) {
		http_response_code( 200 );
		wp_send_json( [ 'error' => 'Operation not allowed' ] );
		die();
	}

	try {
		$data = call_user_func_array( $action, [] );
	} catch ( Soap_Exception $e ) {
		$logger = \wc_get_logger();
		$logger->error( $e->getMessage(), [ 'source' => 'wecorreos' ] );
		$data = [ 'error' => $e->getMessage() ];
	} catch ( \Exception $e ) {
		$data = [ 'error' => $e->getMessage() ];
	}

	http_response_code( 200 );
	wp_send_json( $data );
	die();
};
