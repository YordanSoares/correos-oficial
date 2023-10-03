<?php
/**
 * Display welcome repository
 *
 * @package wooenvio/wecorreos/welcome
 */

namespace WooEnvio\WECorreos\Welcome;

/**
 * Send email
 */
function send_email() {
	$request_data = validate_request_data();
	if ( false === $request_data ) {
		\wp_safe_redirect( settings_page_with_error_email_message_url());
		die();
	}
	\wp_mail(
		[ 'maria.gallego@correos.com', 'lara.barrientos@correos.com' ],
		'Solicitud Alta Cliente',
		build_email_message( $request_data),
		[ 'Content-Type: text/html; charset=UTF-8' ],
		build_csv_attached_file( $request_data)
	);
}

/**
 * Build email message
 *
 * @param array $request_data Request.
 * @return string
 */
function build_email_message( $request_data ) {

	$company        = $request_data['company'];
	$contact_person = $request_data['contact_person'];
	$state          = $request_data['state'];
	$phone          = $request_data['phone'];
	$email          = $request_data['email'];
	$comment        = $request_data['comment'];

	ob_start();
	require __DIR__ . '/email/request-customer-correos.php';
	return ob_get_clean();
}

/**
 * Validate data for email
 */
function validate_request_data() {
	$company        = \sanitize_text_field( trim( isset( $_REQUEST['company']) ? $_REQUEST['company'] : '' ) );
	$contact_person = \sanitize_text_field( trim( isset( $_REQUEST['contact_person']) ? $_REQUEST['contact_person'] : '' ) );
	$state          = \sanitize_text_field( trim( isset( $_REQUEST['state']) ? $_REQUEST['state'] : '' ) );
	$phone          = \wc_sanitize_phone_number( trim( isset( $_REQUEST['phone']) ? $_REQUEST['phone'] : '' ) );
	$email          = \sanitize_email( trim( isset( $_REQUEST['email']) ? $_REQUEST['email'] : '' ) );
	$comment        = \sanitize_text_field( trim( isset( $_REQUEST['comment']) ? $_REQUEST['comment'] : '' ) );

	if ( empty( $company ) ) {
		return false;
	}
	if ( empty( $contact_person ) ) {
		return false;
	}
	if ( empty( $state ) ) {
		return false;
	}
	if ( empty( $phone ) ) {
		return false;
	}
	if ( empty( $email ) || false === filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		return false;
	}

	return compact( 'company', 'contact_person', 'state', 'phone', 'email', 'comment');
}

/**
 * Display setting page with error message
 */
function settings_page_with_error_email_message_url() {
	return \add_query_arg( [
		'page'                 => 'wecorreos_settings',
		'display_request_form' => true,
		'email_error'          => true,
		'company'              => \sanitize_text_field( trim( isset( $_REQUEST['company']) ? $_REQUEST['company'] : '' ) ),
		'contact_person'       => \sanitize_text_field( trim( isset( $_REQUEST['contact_person']) ? $_REQUEST['contact_person'] : '' ) ),
		'state'                => \sanitize_text_field( trim( isset( $_REQUEST['state']) ? $_REQUEST['state'] : '' ) ),
		'phone'                => \wc_sanitize_phone_number( trim( isset( $_REQUEST['phone']) ? $_REQUEST['phone'] : '' ) ),
		'email'                => \sanitize_email( trim( isset( $_REQUEST['email']) ? $_REQUEST['email'] : '' ) ),
		'comment'              => \sanitize_text_field( trim( isset( $_REQUEST['comment']) ? $_REQUEST['comment'] : '' ) ),
	], \admin_url( 'admin.php' ) );
}
