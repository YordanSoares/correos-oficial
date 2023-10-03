<?php
/**
 * Citypaq shipping Correos webservice
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\CorreosWs\ByCpCache;

const PREFIX_CITYPAQS_BY_CP = 'wecorreos_citypaqs_by_cp';

/**
 * Get cached Citypaqs by postal code
 *
 * @param string $cp Postal code.
 * @return array
 */
function obtain_cached_citypaqs_by_cp( $cp ) {
	$citypaqs = \get_transient( citypaqs_by_cp_transient_key( $cp) );
	return false === $citypaqs ? [] : $citypaqs;
}

/**
 * Store Citypaqs by postal code to cache
 *
 * @param string $cp Postal code.
 * @param array  $citypaqs Citypaq.
 */
function store_to_cache_citypaqs_by_cp( $cp, $citypaqs ) {
	\set_transient( citypaqs_by_cp_transient_key( $cp), $citypaqs);
}

/**
 * Cache key for Citypaqs by postal code
 *
 * @param string $cp Postal code.
 * @return string
 */
function citypaqs_by_cp_transient_key( $cp ) {
	return sprintf( '%s_%s', PREFIX_CITYPAQS_BY_CP, $cp);
}
