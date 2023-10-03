<?php
/**
 * Citypaq ajax actions for checkout and backend
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\Ajax\Favorites;

use function WooEnvio\WECorreos\Citypaq\Options\citypaq_options_favorites;
use function WooEnvio\WECorreos\Shared\Ajax\ajax_response;
use function WooEnvio\WECorreos\Shared\Template\render;

/**
 * Obtain citypaqs favorites selector element form
 */
function ajax_obtain_citypaqs_selector_favorites() {

	ajax_response( function() {
		$citypaq_user = \sanitize_text_field( $_POST['citypaq_user'] );
		$citypaqs     = citypaq_options_favorites( $citypaq_user );
		return [
			'success' => build_success_message( $citypaqs, $citypaq_user),
			'replace' => [
				'id'      => 'wecorreos-select-citypaq-element',
				'content' => render( 'shipping::citypaq-selector', compact( 'citypaqs', 'citypaq_user' ) ),
			],
		];
	} );
}

/**
 * Build success message
 *
 * @param array  $citypaqs Citypaqs.
 * @param string $citypaq_user Citypaq user.
 * @return string
 */
function build_success_message( $citypaqs, $citypaq_user ) {
	return sprintf('%s <strong> %s </strong>',
		count( $citypaqs ) > 1 ? __( 'Favorites citypaqs for user:', 'correoswc' ) : __( 'No Citypaqs for user:', 'correoswc' ),
		$citypaq_user
	);
}
