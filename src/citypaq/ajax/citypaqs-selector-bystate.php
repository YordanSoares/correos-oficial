<?php
/**
 * Citypaq ajax actions for checkout and backend
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\Ajax\ByState;

use function WooEnvio\WECorreos\Citypaq\Options\citypaq_options_by_state;
use function WooEnvio\WECorreos\Citypaq\States\state_name_by_code;
use function WooEnvio\WECorreos\Shared\Ajax\ajax_response;
use function WooEnvio\WECorreos\Shared\Template\render;

/**
 * Obtain citypaqs state selector element form
 */
function ajax_obtain_citypaqs_selector_by_state() {

	ajax_response( function() {
		$state    = \sanitize_text_field( $_POST['state'] );
		$citypaqs = citypaq_options_by_state( $state );
		return [
			'success' => build_success_message( $citypaqs, $state),
			'replace' => [
				'id'      => 'wecorreos-select-citypaq-element',
				'content' => render( 'shipping::citypaq-selector', compact( 'citypaqs' ) ),
			],
		];
	} );
}

/**
 * Build success message
 *
 * @param array  $citypaqs Citypaqs.
 * @param string $state State of country.
 * @return string
 */
function build_success_message( $citypaqs, $state ) {
	return sprintf('%s <strong> %s </strong>',
		count( $citypaqs ) > 1 ? __( 'Citypaqs updated for state:', 'correoswc' ) : __( 'No Citypaqs for state:', 'correoswc' ),
		state_name_by_code( $state )
	);
}
