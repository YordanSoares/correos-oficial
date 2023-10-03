<?php
/**
 * Documents
 *
 * @package wooenvio/wecorreos/document
 */

namespace WooEnvio\WECorreos\Document;

/**
 * Init hooks
 */
function document_init() {
	add_action(
		'admin_action_view',
		function () {
			if ( ! verify_args_and_nonce() ) {
				return;
			}
			document_download( \sanitize_text_field( $_REQUEST['file'] ) );
		}
	);
}
