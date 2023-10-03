<?php
/**
 * Citypaq shipping Correos webservice
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\CorreosWs\ByCodeCache;

const PREFIX_CITYPAQ_BY_CODE = 'wecorreos_citypaq_by_code';

/**
 * Get cached Citypaqs by code
 *
 * @param string $code Code.
 * @return array
 */
function obtain_cached_citypaq_by_code( $code ) {
	$citypaq = \get_transient( citypaq_by_code_transient_key( $code) );
	return false === $citypaq ? [] : $citypaq;
}

/**
 * Store Citypaqs by code to cache
 *
 * @param array $citypaqs Citypaqs.
 */
function store_to_cache_citypaqs_by_code( $citypaqs ) {
	array_map(function( $citypaq ) {
		\set_transient( citypaq_by_code_transient_key( $citypaq['code']), $citypaq);
	}, $citypaqs);
}

/**
 * Cache key for Citypaqs by code
 *
 * @param string $code Code.
 * @return string
 */
function citypaq_by_code_transient_key( $code ) {
	return sprintf( '%s_%s', PREFIX_CITYPAQ_BY_CODE, $code);
}
