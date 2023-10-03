<?php
/**
 * Acions welcome
 *
 * @package wooenvio/wecorreos/welcome
 */

namespace WooEnvio\WECorreos\Welcome;

const ACTION                               = 'wecorreosn';
const NONCE_ACTION                         = '_wecorreos_';
const ALREADY_CORREOS_USER_ACTION_TYPE     = 'already_correos_user_action_type';
const SEND_CORREOS_USER_EMAIL_REQUEST_TYPE = 'send_correos_user_email_request_type';

/**
 * Init hooks
 */
function init() {
	\add_action(
		'admin_action_' . ACTION,
		function () {
			if ( ! verify_nonce() ) {
				return;
			}
			$action_type = isset( $_REQUEST['action_type'] ) ? \sanitize_text_field( $_REQUEST['action_type'] ) : '';
			if ( ALREADY_CORREOS_USER_ACTION_TYPE === $action_type ) {
				update_no_display_welcome();
				\wp_safe_redirect( settings_page_url());
			}
			if ( SEND_CORREOS_USER_EMAIL_REQUEST_TYPE === $action_type ) {
				send_email();
				update_no_display_welcome();
				\wp_safe_redirect( settings_page_with_sended_email_message_url());
			}
		}
	);
}

/**
 * GET action
 */
function action() {
	return ACTION;
}

/**
 * Nonce
 */
function nonce() {
	return \wp_create_nonce( NONCE_ACTION );
}

/**
 * Verify Nonce
 */
function verify_nonce() {
	$nonce = isset( $_REQUEST['_wpnonce'] ) ? $_REQUEST['_wpnonce'] : '';
	return \wp_verify_nonce( $nonce, NONCE_ACTION );
}

/**
 * Correos user url
 */
function already_correos_user_url() {
	$base = \admin_url( 'admin.php' );
	$args = [
		'action'      => ACTION,
		'action_type' => ALREADY_CORREOS_USER_ACTION_TYPE,
		'_wpnonce'    => nonce(),
	];
	return \add_query_arg( $args, $base );
}

/**
 * Send email
 */
function send_correos_user_email_request_action() {
	return SEND_CORREOS_USER_EMAIL_REQUEST_TYPE;
}

/**
 * Setting page url
 */
function settings_page_url() {
	return \add_query_arg( [ 'page' => 'wecorreos_settings' ], \admin_url( 'admin.php' ) );
}

/**
 * Setting page url with emails send message
 */
function settings_page_with_sended_email_message_url() {
	return \add_query_arg( [
		'page'    => 'wecorreos_settings',
		'message' => 'sended_email',
	], \admin_url( 'admin.php' ) );
}
