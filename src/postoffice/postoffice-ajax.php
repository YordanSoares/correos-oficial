<?php
/**
 * Postoffice ajax actions for checkout and backend
 *
 * @package wooenvio/wecorreos/postoffice
 */

namespace WooEnvio\WECorreos\Postoffice\Ajax;

use function WooEnvio\WECorreos\Postoffice\Options\postoffice_options_by_cp;
use function WooEnvio\WECorreos\Shared\Ajax\ajax_response;
use function WooEnvio\WECorreos\Shared\Template\render;

/**
 * Obtain postoffice by cp ajax action
 */
function ajax_obtain_postoffices_by_cp() {

	ajax_response( function() {
		$postalcode  = postalcode_in_request();
		$postoffices = postoffice_options_by_cp( $postalcode );
		return [
			'success' => build_success( $postoffices, $postalcode),
			'replace' => [
				'id'      => 'wecorreos-select-office-element',
				'content' => render( 'shipping::postoffice-selector', compact( 'postoffices', 'postalcode' ) ),
			],
		];
	} );
}

/**
 * Build success message
 *
 * @param array  $postoffices Post offices.
 * @param string $postalcode Postalcode.
 * @return string
 */
function build_success( $postoffices, $postalcode ) {
	return sprintf('%s <strong> %s </strong>',
		count( $postoffices ) > 1 ? __( 'Offices updated for postal code:', 'correoswc' ) : __( 'No Offices for postal code:', 'correoswc' ),
		$postalcode
	);
}

/**
 * Postoffice code in checkout
 *
 * @return string
 */
function postalcode_in_request() {
	return \sanitize_text_field( $_POST['postalcode'] );
}
