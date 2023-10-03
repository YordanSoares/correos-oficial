<?php
/**
 * Acions welcome
 *
 * @package wooenvio/wecorreos/welcome
 */

namespace WooEnvio\WECorreos\Welcome;

/**
 * Build email sent message
 */
function build_email_sended_message() {
	return sprintf(
		'<div class="notice notice-success is-dismissible"><p>%s</p></div>',
		__( 'Thank you, your message has been sent successfully. Our commercial services will contact you shortly.', 'correoswc')
	);
}

/**
 * Build error email message
 */
function build_email_error_message() {
	return sprintf(
		'<div class="notice notice-error is-dismissible"><p>%s</p></div>',
		__( 'Check the fields please', 'correoswc')
	);
}
