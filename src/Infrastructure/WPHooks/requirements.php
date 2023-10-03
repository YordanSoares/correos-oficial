<?php //phpcs:ignoreFile
/**
 * WPHooks
 *
 * @package wooenvio/wecorreos
 */

use \WooEnvio\WECorreos\Infrastructure\Common\Requirements\Requirements;

$cowc_container['maybe_display_requirement_messages_transient'] = function() {

	set_transient( 'maybe_display_requirement_messages_transient', true, 5 );
};

$cowc_container['maybe_display_requirement_messages'] = function( $c ) {

	if ( ! get_transient( 'maybe_display_requirement_messages_transient' ) ) {
		return;
	}

	$requirements = new Requirements();

	if ( $requirements->are_satisfied() ) {
		return;
	}

	$messages = implode( __( ' and ', 'correoswc' ), $requirements->messages() );

	$error = sprintf( __( 'Correos Oficial plugin needs %s', 'correoswc' ), $messages );

	echo $c['plates']->render(
		'error', [
			'error'        => $error,
			'link_support' => $c['we_support'],
		]
	);

	delete_transient( 'maybe_display_requirement_messages_transient' );
};

add_action( 'admin_notices', $cowc_container->raw( 'maybe_display_requirement_messages' ) );
