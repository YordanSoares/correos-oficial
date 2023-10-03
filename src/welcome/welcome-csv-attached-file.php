<?php
/**
 * Actions welcome
 *
 * @package wooenvio/wecorreos/welcome
 */

/**
 * Build csv file and return path file
 *
 * @param array $request_data Request.
 * @return string
 */
function build_csv_attached_file( $request_data ) {
	// phpcs:ignore
	file_put_contents( csv_path(), csv_content( $request_data));
	return csv_path();
}

/**
 * Build csv content
 *
 * @param array $request_data Request.
 * @return string
 */
function csv_content( $request_data ) {
	unset( $request_data['comment']);
	return sprintf("%s\n%s",
		implode( csv_header(), ';'),
		implode( $request_data, ';')
	);
}

/**
 * Build csv header content
 */
function csv_header() {
	return [
		'Nombre Empresa',
		'Nombre de pila',
		'Localidad',
		'Teléfono',
		'Dir cor elec',
	];
}

/**
 * Csv path
 */
function csv_path() {
	return __DIR__ . '/solicitud_alta.csv';
}
