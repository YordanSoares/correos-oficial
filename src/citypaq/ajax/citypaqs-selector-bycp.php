<?php
/**
 * Citypaq ajax actions for checkout and backend
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\Ajax\ByCp;

use function WooEnvio\WECorreos\Citypaq\Options\citypaq_options_by_cp;
use function WooEnvio\WECorreos\Shared\Ajax\ajax_response;
use function WooEnvio\WECorreos\Shared\Template\render;

/**
 * Obtain citypaqs selector element form by cp ajax action
 */
function ajax_obtain_citypaqs_selector_by_cp() {

	ajax_response( function() {
		$postalcode = \sanitize_text_field( $_POST['postalcode'] );
		$citypaqs   = citypaq_options_by_cp( $postalcode );

		return [
			'success' => build_success_message( $citypaqs, $postalcode),
			'replace' => [
				'id'      => 'wecorreos-select-citypaq-element',
				'content' => render( 'shipping::citypaq-selector', compact( 'citypaqs', 'postalcode' ) ),
			],
		];
	} );
}

/**
 * Build success message
 *
 * @param array  $citypaqs Citypaqs.
 * @param string $postalcode Postalcode.
 * @return string
 */
function build_success_message( $citypaqs, $postalcode ) {
	return sprintf('%s <strong> %s </strong>',
		count( $citypaqs ) > 1 ? __( 'Citypaqs updated for postal code:', 'correoswc' ) : __( 'No Citypaqs for postal code:', 'correoswc' ),
		$postalcode
	);
}
