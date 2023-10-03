<?php
/**
 * Documents
 *
 * @package wooenvio/wecorreos/document
 */

namespace WooEnvio\WECorreos\Document;

const ACTION       = 'view';
const TYPE_ACTION  = 'wecorreos_doc';
const NONCE_ACTION = 'wecorreos_doc';

/**
 * Build Download document link
 *
 * @param string $relative_path Relative path from upload dir.
 * @return string
 */
function build_download_document_link( $relative_path ) {
	$args = [
		'action' => ACTION,
		'type'   => TYPE_ACTION,
		'file'   => extract_file_name( $relative_path ),
	];
	return \esc_url( \wp_nonce_url( \add_query_arg( $args, \admin_url() ), NONCE_ACTION ) );
}

/**
 * Extract file name from path (full url to file)
 *
 * @param string $path Absolute $path.
 * @return string
 */
function extract_file_name( $path ) {
	$base_url = wp_upload_dir()['baseurl'] . '/wecorreos/';
	$path     = str_replace( $base_url, '', $path );
	return strtok( $path, '?' );
}

/**
 * Verifiy Download document nonce
 *
 * @return bool
 */
function verify_args_and_nonce() {
	$type = $_REQUEST['type'] ? \sanitize_text_field( $_REQUEST['type'] ) : '';
	if ( TYPE_ACTION !== $type ) {
		return false;
	}
	$type = $_REQUEST['type'] ? \sanitize_text_field( $_REQUEST['type'] ) : '';
	if ( TYPE_ACTION !== $type ) {
		return false;
	}
	$nonce = $_REQUEST['_wpnonce'] ? \sanitize_text_field( $_REQUEST['_wpnonce'] ) : '';
	return \wp_verify_nonce( $nonce, NONCE_ACTION );
}

