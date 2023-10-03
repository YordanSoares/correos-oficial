<?php
/**
 * Citypaq shipping Correos webservice
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\CorreosWs\ByStateCache;

const PREFIX_CITYPAQS_BYSTATE = 'wecorreos_citypaq_bystate';

/**
 * Get cached Citypaqs by state
 *
 * @param string $state State code.
 * @return array
 */
function obtain_cached_citypaqs_by_state( $state ) {
	$citypaqs = \get_transient( citypaqs_by_state_transient_key( $state ) );
	return false === $citypaqs ? [] : $citypaqs;
}

/**
 * Store Citypaqs by postal code to cache
 *
 * @param string $state City paq user.
 * @param array  $citypaqs Citypaq.
 */
function store_to_cache_citypaqs_by_state( $state, $citypaqs ) {
	\set_transient( citypaqs_by_state_transient_key( $state ), $citypaqs);
}

/**
 * Cache key for Citypaqs by postal code
 *
 * @param string $state City paq user.
 * @return string
 */
function citypaqs_by_state_transient_key( $state ) {
	return sprintf( '%s_%s', PREFIX_CITYPAQS_BYSTATE, $state );
}
