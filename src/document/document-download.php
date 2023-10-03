<?php
/**
 * Documents
 *
 * @package wooenvio/wecorreos/document
 */

namespace WooEnvio\WECorreos\Document;

/**
 * Download pdf document
 *
 * @param string $file_name File name.
 */
function document_download( $file_name ) {
	$path = build_path( $file_name );
	header( 'Content-type: application/pdf' );
	header( 'Content-Disposition: inline; filename = "' . basename( $path ) . '"' );
	header( 'Content-Transfer-Encoding: binary' );
	header( 'Content-Length: ' . filesize( $path ) );
	header( 'Accept-Ranges: bytes' );
	// phpcs:ignore
	@readfile( $path );
	exit();
}

/**
 * Build path to file
 *
 * @param string $file_name File name.
 * @return string
 */
function build_path( $file_name ) {
	return sprintf(
		'%s/wecorreos/%s',
		\wp_upload_dir()['basedir'],
		$file_name
	);
}

