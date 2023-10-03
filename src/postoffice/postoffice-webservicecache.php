<?php
/**
 * Postoffice shipping Correos webservice cache
 *
 * @package wooenvio/wecorreos/postoffice
 */

namespace WooEnvio\WECorreos\Postoffice\WebServiceCache;

const PREFIX_POSTOFFICES_BY_CP  = 'wecorreos_postoffices_by_cp';
const PREFIX_POSTOFFICE_BY_CODE = 'wecorreos_postoffice_by_code';

/**
 * Get cached Postoffices by postal code
 *
 * @param string $cp Postal code.
 * @return array
 */
function obtain_cached_postoffices_by_cp( $cp ) {
	$postoffices = \get_transient( postoffices_by_cp_transient_key( $cp) );
	return false === $postoffices ? [] : $postoffices;
}

/**
 * Store Postoffices by postal code to cache
 *
 * @param string $cp Postal code.
 * @param array  $postoffices Postoffice.
 */
function store_to_cache_postoffices_by_cp( $cp, $postoffices ) {
	\set_transient( postoffices_by_cp_transient_key( $cp), $postoffices);
}

/**
 * Cache key for Postoffices by postal code
 *
 * @param string $cp Postal code.
 * @return string
 */
function postoffices_by_cp_transient_key( $cp ) {
	return sprintf( '%s_%s', PREFIX_POSTOFFICES_BY_CP, $cp);
}

/**
 * Get cached Postoffices by code
 *
 * @param string $code Code.
 * @return array
 */
function obtain_cached_postoffice_by_code( $code ) {
	$postoffice = \get_transient( postoffice_by_code_transient_key( $code ) );
	return false === $postoffice ? [] : $postoffice;
}

/**
 * Store Postoffices by code to cache
 *
 * @param array $postoffices Postoffices.
 */
function store_to_cache_postoffices_by_code( $postoffices ) {
	array_map(function( $postoffice ) {
		\set_transient( postoffice_by_code_transient_key( $postoffice['unidad']), $postoffice);
	}, $postoffices);
}
/**
 * Cache key for Postoffices by code
 *
 * @param string $code Code.
 * @return string
 */
function postoffice_by_code_transient_key( $code ) {
	return sprintf( '%s_%s', PREFIX_POSTOFFICE_BY_CODE, $code);
}
